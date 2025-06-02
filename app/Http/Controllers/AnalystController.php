<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Services\AprioriService;
use Illuminate\Http\Request;

class AnalystController extends Controller
{
    private $dataHistoris = [];
    public function __construct()
    {
        // Ambil semua data dari tabel `data`
        // Mapping kolom: year -> tahun, organic -> organik, unorganic -> anorganik
        $this->dataHistoris = Data::select('year', 'organic', 'unorganic')->get()->map(function($item) {
            return [
                'tahun' => (int) $item->year,
                'organik' => (float) $item->organic,
                'anorganik' => (float) $item->unorganic,
            ];
        })->toArray();
    }

    /**
     * Hitung jarak Euclidean antara dua titik data
     * Rumus:
     * d = sqrt(Σ (x_i - y_i)^2)
     * dengan x_i dan y_i nilai fitur ke-i dari dua titik
     */
    private function euclideanDistance(array $point1, array $point2): float
    {
        $sum = 0;
        foreach ($point1 as $key => $val) {
            $sum += pow($val - $point2[$key], 2);
        }
        return sqrt($sum);
    }

    /**
     * Klasifikasi KNN
     * Langkah:
     * 1. Hitung jarak Euclidean ke semua data historis
     * 2. Urutkan dan ambil k tetangga terdekat
     * 3. Hitung rata-rata organik dan anorganik tetangga
     * 4. Prediksi kelas: Organik jika rata-rata organik >= anorganik, else Anorganik
     */
    private function knnClassification(array $data, array $input, int $k): array
    {
        $distances = [];
        foreach ($data as $index => $row) {
            $features = ['tahun', 'organik', 'anorganik'];
            $point = [];
            foreach ($features as $f) {
                $point[$f] = $row[$f];
            }
            $dist = $this->euclideanDistance($point, $input);
            $distances[] = ['index' => $index, 'distance' => $dist, 'data' => $row];
        }

        // Urutkan berdasarkan jarak terdekat (kecil ke besar)
        usort($distances, fn($a, $b) => $a['distance'] <=> $b['distance']);

        // Ambil k tetangga terdekat
        $neighbors = array_slice($distances, 0, $k);

        // Hitung rata-rata organik dan anorganik dari tetangga
        $sumOrganik = 0;
        $sumAnorganik = 0;
        foreach ($neighbors as $n) {
            $sumOrganik += $n['data']['organik'];
            $sumAnorganik += $n['data']['anorganik'];
        }
        $avgOrganik = $sumOrganik / $k;
        $avgAnorganik = $sumAnorganik / $k;

        // Tentukan kelas prediksi
        $kelas = $avgOrganik >= $avgAnorganik ? 'Organik' : 'Anorganik';

        return [
            'jarak_ke_setiap_data' => array_map(fn($d) => [
                'tahun' => $d['data']['tahun'],
                'organik' => $d['data']['organik'],
                'anorganik' => $d['data']['anorganik'],
                'jarak' => round($d['distance'], 4),
            ], $distances),
            'tetangga_terdekat' => array_map(fn($n) => [
                'tahun' => $n['data']['tahun'],
                'organik' => $n['data']['organik'],
                'anorganik' => $n['data']['anorganik'],
                'jarak' => round($n['distance'], 4),
            ], $neighbors),
            'rata_rata_organik_tetangga' => round($avgOrganik, 2),
            'rata_rata_anorganik_tetangga' => round($avgAnorganik, 2),
            'kelas_prediksi' => $kelas,
        ];
    }

    /**
     * KNN Regresi: prediksi nilai target dengan rata-rata target k tetangga terdekat
     */
    private function knnRegression(array $data, array $input, int $k, string $target): float
    {
        $distances = [];
        foreach ($data as $index => $row) {
            $features = ['tahun', 'organik', 'anorganik'];
            $point = [];
            foreach ($features as $feature) {
                $point[$feature] = $row[$feature];
            }
            $dist = $this->euclideanDistance($point, $input);
            $distances[] = ['index' => $index, 'distance' => $dist, 'data' => $row];
        }
        usort($distances, fn($a, $b) => $a['distance'] <=> $b['distance']);
        $neighbors = array_slice($distances, 0, $k);
        $sumTarget = 0;
        foreach ($neighbors as $neighbor) {
            $sumTarget += $neighbor['data'][$target];
        }
        return $sumTarget / $k;
    }

    /**
     * Hitung parameter regresi linear:
     * slope (m) dan intercept (c) untuk persamaan y = m x + c
     * Rumus slope:
     * m = (n Σxy - Σx Σy) / (n Σx² - (Σx)²)
     * Rumus intercept:
     * c = (Σy - m Σx) / n
     */
    private function linearRegression(array $data, string $fitur, string $target): array
    {
        $n = count($data);
        $sumX = 0;
        $sumY = 0;
        $sumXY = 0;
        $sumX2 = 0;
        foreach ($data as $d) {
            $x = $d[$fitur];
            $y = $d[$target];
            $sumX += $x;
            $sumY += $y;
            $sumXY += $x * $y;
            $sumX2 += $x * $x;
        }
        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $intercept = ($sumY - $slope * $sumX) / $n;
        return ['slope' => $slope, 'intercept' => $intercept];
    }

    /**
     * Gunakan model regresi linear untuk prediksi nilai y dari x
     * y = m x + c
     */
    private function predictLinear(float $x, array $model): float
    {
        return $model['slope'] * $x + $model['intercept'];
    }

    /**
     * Evaluasi klasifikasi dengan leave-one-out cross-validation
     * Rumus akurasi:
     * Akurasi = (Jumlah prediksi benar / Total data) * 100%
     */
    private function evaluateKNNClassification(int $k): array
    {
        $correct = 0;
        $total = count($this->dataHistoris);
        for ($i=0; $i<$total; $i++) {
            $testData = $this->dataHistoris[$i];
            $trainData = array_filter($this->dataHistoris, fn($v, $idx) => $idx !== $i, ARRAY_FILTER_USE_BOTH);
            $knnRes = $this->knnClassification(array_values($trainData), $testData, $k);
            $prediksi = $knnRes['kelas_prediksi'];
            $kelasAsli = $testData['organik'] >= $testData['anorganik'] ? 'Organik' : 'Anorganik';
            if ($prediksi === $kelasAsli) {
                $correct++;
            }
        }
        $akurasi = $correct / $total * 100;
        return [
            'total_data' => $total,
            'benar' => $correct,
            'akurasi_persen' => round($akurasi, 2),
        ];
    }

    /**
     * Evaluasi regresi dengan leave-one-out cross-validation
     * Menghitung Mean Absolute Error (MAE):
     * MAE = (1/n) Σ |y_i - ŷ_i|
     */
    private function evaluateKNNRegression(int $k, string $target): array
    {
        $total = count($this->dataHistoris);
        $errors = [];
        for ($i=0; $i<$total; $i++) {
            $testData = $this->dataHistoris[$i];
            $trainData = array_filter($this->dataHistoris, fn($v, $idx) => $idx !== $i, ARRAY_FILTER_USE_BOTH);
            $prediksi = $this->knnRegression(array_values($trainData), $testData, $k, $target);
            $error = abs($testData[$target] - $prediksi);
            $errors[] = $error;
        }
        $mae = array_sum($errors) / $total;
        return [
            'total_data' => $total,
            'mean_absolute_error' => round($mae, 2),
        ];
    }

    public function index()
    {
        $k = 3;

        if (count($this->dataHistoris) === 0) {
            return abort(404, 'Data historis tidak ditemukan');
        }

        $avgOrganik = array_sum(array_column($this->dataHistoris, 'organik')) / count($this->dataHistoris);
        $avgAnorganik = array_sum(array_column($this->dataHistoris, 'anorganik')) / count($this->dataHistoris);

        $inputBaru = ['tahun' => 2025, 'organik' => $avgOrganik, 'anorganik' => $avgAnorganik];

        $knnResult = $this->knnClassification($this->dataHistoris, $inputBaru, $k);

        $modelOrganik = $this->linearRegression($this->dataHistoris, 'tahun', 'organik');
        $modelAnorganik = $this->linearRegression($this->dataHistoris, 'tahun', 'anorganik');

        $prediksiOrganik = $this->predictLinear($inputBaru['tahun'], $modelOrganik);
        $prediksiAnorganik = $this->predictLinear($inputBaru['tahun'], $modelAnorganik);

        $evaluasiKlasifikasi = $this->evaluateKNNClassification($k);
        $evaluasiRegresiOrganik = $this->evaluateKNNRegression($k, 'organik');
        $evaluasiRegresiAnorganik = $this->evaluateKNNRegression($k, 'anorganik');

        $regresi = [
            'model_organik' => $modelOrganik,
            'model_anorganik' => $modelAnorganik,
            'prediksi_organik_2025' => round($prediksiOrganik, 2),
            'prediksi_anorganik_2025' => round($prediksiAnorganik, 2),
        ];

        return view('pages.result', [
            'title' => 'Analyst',
            'input' => $inputBaru,
            'knn' => $knnResult,
            'regresi' => $regresi,
            'evaluasi' => [
                'klasifikasi' => $evaluasiKlasifikasi,
                'regresi_organik' => $evaluasiRegresiOrganik,
                'regresi_anorganik' => $evaluasiRegresiAnorganik,
            ],
        ]);
    }
}


    // public function apriori(Request $request)
    // {
    //     $data = Data::all();

    //     $transactions = [];
    //     foreach ($data as $row) {
    //         $itemset = [];

    //         if (!empty($row->income)) {
    //             $itemset[] = "Income=" . $row->income;
    //         }
    //         if (!empty($row->spending)) {
    //             $itemset[] = "Spending=" . $row->spending;
    //         }
    //         if (!empty($row->job)) {
    //             $itemset[] = "Job=" . $row->job;
    //         }
    //         if (!empty($row->disability_type)) {
    //             $itemset[] = "Disability yype=" . $row->disability_type;
    //         }
    //         if (!empty($row->residence_condition)) {
    //             $itemset[] = "Residence condition=" . $row->residence_condition;
    //         }
    //         if (!empty($row->electricity_capacity)) {
    //             $itemset[] = "Electricity capacity=" . $row->electricity_capacity;
    //         }

    //         $transactions[] = $itemset;
    //     }

    //     $minSupport = $request->input('minSupport');     
    //     $minConfidence = $request->input('minConfidence');  
    //     $apriori = new AprioriService($transactions, $minSupport, $minConfidence);
    //     $apriori->run();

    //     $data = [
    //         'title' => 'Analyst',
    //         'subTitle' => null,
    //         'frequentItemsets' => $apriori->getFrequentItemsets(),
    //         'associationRules' => $apriori->getAssociationRules()
    //     ];        

    //     return view('pages.apriori', $data);
    // }
// }
