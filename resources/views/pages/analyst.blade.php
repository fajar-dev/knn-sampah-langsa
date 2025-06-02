<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hasil Prediksi Sampah</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2 { margin-top: 40px; }
    </style>
</head>
<body>
    <h1>Hasil Prediksi dan Klasifikasi Sampah Tahun 2025</h1>

    <h2>Input Data Baru</h2>
    <table>
        <tr>
            <th>Tahun</th>
            <th>Sampah Organik (ton)</th>
            <th>Sampah Anorganik (ton)</th>
        </tr>
        <tr>
            <td>{{ $input['tahun'] }}</td>
            <td>{{ number_format($input['organik'], 2) }}</td>
            <td>{{ number_format($input['anorganik'], 2) }}</td>
        </tr>
    </table>

    <h2>Jarak Euclidean ke Setiap Data Historis</h2>
    <table>
        <tr>
            <th>Tahun</th>
            <th>Sampah Organik (ton)</th>
            <th>Sampah Anorganik (ton)</th>
            <th>Jarak</th>
        </tr>
        @foreach ($knn['jarak_ke_setiap_data'] as $data)
        <tr>
            <td>{{ $data['tahun'] }}</td>
            <td>{{ number_format($data['organik'], 2) }}</td>
            <td>{{ number_format($data['anorganik'], 2) }}</td>
            <td>{{ number_format($data['jarak'], 4) }}</td>
        </tr>
        @endforeach
    </table>

    <h2>3 Tetangga Terdekat</h2>
    <table>
        <tr>
            <th>Tahun</th>
            <th>Sampah Organik (ton)</th>
            <th>Sampah Anorganik (ton)</th>
            <th>Jarak</th>
        </tr>
        @foreach ($knn['tetangga_terdekat'] as $data)
        <tr>
            <td>{{ $data['tahun'] }}</td>
            <td>{{ number_format($data['organik'], 2) }}</td>
            <td>{{ number_format($data['anorganik'], 2) }}</td>
            <td>{{ number_format($data['jarak'], 4) }}</td>
        </tr>
        @endforeach
    </table>

    <h2>Rata-rata Tetangga Terdekat</h2>
    <table>
        <tr>
            <th>Rata-rata Sampah Organik (ton)</th>
            <th>Rata-rata Sampah Anorganik (ton)</th>
            <th>Kelas Prediksi</th>
        </tr>
        <tr>
            <td>{{ number_format($knn['rata_rata_organik_tetangga'], 2) }}</td>
            <td>{{ number_format($knn['rata_rata_anorganik_tetangga'], 2) }}</td>
            <td>{{ $knn['kelas_prediksi'] }}</td>
        </tr>
    </table>

    <h2>Model Regresi Linear</h2>
    <table>
        <tr>
            <th></th>
            <th>Slope</th>
            <th>Intercept</th>
        </tr>
        <tr>
            <td>Sampah Organik</td>
            <td>{{ number_format($regresi['model_organik']['slope'], 4) }}</td>
            <td>{{ number_format($regresi['model_organik']['intercept'], 2) }}</td>
        </tr>
        <tr>
            <td>Sampah Anorganik</td>
            <td>{{ number_format($regresi['model_anorganik']['slope'], 4) }}</td>
            <td>{{ number_format($regresi['model_anorganik']['intercept'], 2) }}</td>
        </tr>
    </table>

    <h2>Prediksi Sampah Tahun 2025</h2>
    <table>
        <tr>
            <th>Sampah Organik (ton)</th>
            <th>Sampah Anorganik (ton)</th>
        </tr>
        <tr>
            <td>{{ number_format($regresi['prediksi_organik_2025'], 2) }}</td>
            <td>{{ number_format($regresi['prediksi_anorganik_2025'], 2) }}</td>
        </tr>
    </table>

    {{-- Tambahan Evaluasi --}}
    <h2>Evaluasi Klasifikasi KNN</h2>
    <table>
        <tr>
            <th>Total Data</th>
            <th>Data Benar</th>
            <th>Akurasi (%)</th>
        </tr>
        <tr>
            <td>{{ $evaluasi['klasifikasi']['total_data'] }}</td>
            <td>{{ $evaluasi['klasifikasi']['benar'] }}</td>
            <td>{{ $evaluasi['klasifikasi']['akurasi_persen'] }}</td>
        </tr>
    </table>

    <h2>Evaluasi Regresi (Mean Absolute Error)</h2>
    <table>
        <tr>
            <th>Jenis Sampah</th>
            <th>MAE (ton)</th>
        </tr>
        <tr>
            <td>Sampah Organik</td>
            <td>{{ $evaluasi['regresi_organik']['mean_absolute_error'] }}</td>
        </tr>
        <tr>
            <td>Sampah Anorganik</td>
            <td>{{ $evaluasi['regresi_anorganik']['mean_absolute_error'] }}</td>
        </tr>
    </table>

    <h2>Visualisasi Prediksi Sampah Tahun 2025</h2>
    <canvas id="prediksiChart" width="600" height="400"></canvas>

    <h2>Visualisasi Akurasi Klasifikasi</h2>
    <canvas id="akurasiChart" width="400" height="400"></canvas>

    <h2>Visualisasi Mean Absolute Error (MAE)</h2>
    <canvas id="maeChart" width="600" height="400"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Chart Prediksi Sampah
    const ctx = document.getElementById('prediksiChart').getContext('2d');
    const prediksiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sampah Organik', 'Sampah Anorganik'],
            datasets: [{
                label: 'Prediksi Sampah (ton) Tahun 2025',
                data: [
                    {{ $regresi['prediksi_organik_2025'] }},
                    {{ $regresi['prediksi_anorganik_2025'] }}
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } },
            responsive: true,
            plugins: {
                legend: { display: true, position: 'top' },
                title: { display: true, text: 'Prediksi Timbulan Sampah Organik dan Anorganik Tahun 2025' }
            }
        }
    });

    // Chart Akurasi Klasifikasi
    const ctxAkurasi = document.getElementById('akurasiChart').getContext('2d');
    const akurasiChart = new Chart(ctxAkurasi, {
        type: 'doughnut',
        data: {
            labels: ['Benar', 'Salah'],
            datasets: [{
                label: 'Akurasi Klasifikasi',
                data: [
                    {{ $evaluasi['klasifikasi']['benar'] }},
                    {{ $evaluasi['klasifikasi']['total_data'] - $evaluasi['klasifikasi']['benar'] }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Distribusi Klasifikasi Benar vs Salah' }
            }
        }
    });

    // Chart MAE
    const ctxMAE = document.getElementById('maeChart').getContext('2d');
    const maeChart = new Chart(ctxMAE, {
        type: 'bar',
        data: {
            labels: ['Sampah Organik', 'Sampah Anorganik'],
            datasets: [{
                label: 'Mean Absolute Error (MAE)',
                data: [
                    {{ $evaluasi['regresi_organik']['mean_absolute_error'] }},
                    {{ $evaluasi['regresi_anorganik']['mean_absolute_error'] }}
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } },
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Error Prediksi Model Regresi' }
            }
        }
    });
    </script>
</body>
</html>
