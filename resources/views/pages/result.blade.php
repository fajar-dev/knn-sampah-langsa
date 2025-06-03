@extends('layouts.app')

@section('content')
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Input Data Baru</span>
                </h3>
            </div>
            <div class="card-body pt-2 table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">Tahun</th>
                            <th class="text-center min-w-100px">Sampah Organik (ton)</th>
                            <th class="text-center min-w-100px">Sampah Anorganik (ton)</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        <tr>
                            <td>
                                <span class="text-gray-800">
                                    {{ $input['tahun'] }}
                                </span>
                            </td>
                            <td class="text-center">{{ number_format($input['organik'], 2) }}</td>
                            <td class="text-center">{{ number_format($input['anorganik'], 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Jarak Euclidean ke Setiap Data Historis</span>
                </h3>
            </div>
            <div class="card-body pt-2 table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">Tahun</th>
                            <th class="text-center min-w-100px">Sampah Organik (ton)</th>
                            <th class="text-center min-w-100px">Sampah Anorganik (ton)</th>
                            <th class="text-center min-w-100px">Jarak</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($knn['jarak_ke_setiap_data'] as $data)
                            <tr>
                                <td>
                                    <span class="text-gray-800">
                                        {{ $data['tahun'] }}
                                    </span>
                                </td>
                                <td class="text-center">{{ number_format($data['organik'], 2) }}</td>
                                <td class="text-center">{{ number_format($data['anorganik'], 2) }}</td>
                                <td class="text-center">{{ number_format($data['jarak'], 4) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bagian Chart -->
    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">3 Tetangga Terdekat</span>
                </h3>
            </div>
            <div class="card-body pt-2 table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">Tahun</th>
                            <th class="text-center min-w-100px">Sampah Organik (ton)</th>
                            <th class="text-center min-w-100px">Sampah Anorganik (ton)</th>
                            <th class="text-center min-w-100px">Jarak</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($knn['tetangga_terdekat'] as $data)
                            <tr>
                                <td>
                                    <span class="text-gray-800">
                                        {{ $data['tahun'] }}
                                    </span>
                                </td>
                                <td class="text-center">{{ number_format($data['organik'], 2) }}</td>
                                <td class="text-center">{{ number_format($data['anorganik'], 2) }}</td>
                                <td class="text-center">{{ number_format($data['jarak'], 4) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Rata-rata Tetangga Terdekat</span>
                </h3>
            </div>
            <div class="card-body pt-2 table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="text-center min-w-100px">Rata-rata Sampah Organik (ton)</th>
                            <th class="text-center min-w-100px">Rata-rata Sampah Anorganik (ton)</th>
                            <th class="text-center min-w-100px">Kelas Prediksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        <tr>
                            <td class="text-center">{{ number_format($knn['rata_rata_organik_tetangga'], 2) }}</td>
                            <td class="text-center">{{ number_format($knn['rata_rata_anorganik_tetangga'], 2) }}</td>
                            <td class="text-center">{{ $knn['kelas_prediksi'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Model Regresi Linear</span>
                </h3>
            </div>
            <div class="card-body pt-2 table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class=" min-w-100px">Jenis</th>
                            <th class="text-center min-w-100px">Slope</th>
                            <th class="text-center min-w-100px">Intercept</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        <tr>
                            <td class="">Sampah Organik</td>
                            <td class="text-center">{{ number_format($regresi['model_organik']['slope'], 4) }}</td>
                            <td class="text-center">{{ number_format($regresi['model_organik']['intercept'], 2) }}</td>
                        </tr>
                        <tr>
                            <td class="">Sampah Anorganik</td>
                            <td class="text-center">{{ number_format($regresi['model_anorganik']['slope'], 4) }}</td>
                            <td class="text-center">{{ number_format($regresi['model_anorganik']['intercept'], 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Prediksi Sampah Tahun 2025</span>
                </h3>
            </div>
            <div class="card-body pt-2 table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="text-center min-w-100px">Sampah Organik (ton)</th>
                            <th class="text-center min-w-100px">Sampah Anorganik (ton)</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        <tr>
                            <td class="text-center">{{ number_format($regresi['prediksi_organik_2025'], 2) }}</td>
                            <td class="text-center">{{ number_format($regresi['prediksi_anorganik_2025'], 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Evaluasi Klasifikasi KNN</span>
                </h3>
            </div>
            <div class="card-body pt-2 table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="text-center min-w-100px">Total Data</th>
                            <th class="text-center min-w-100px">Data Benar</th>
                            <th class="text-center min-w-100px">Akurasi (%)</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        <tr>
                            <td class="text-center">{{ $evaluasi['klasifikasi']['total_data'] }}</td>
                            <td class="text-center">{{ $evaluasi['klasifikasi']['benar'] }}</td>
                            <td class="text-center">{{ $evaluasi['klasifikasi']['akurasi_persen'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Evaluasi Regresi (Mean Absolute Error)</span>
                </h3>
            </div>
            <div class="card-body pt-2 table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">Jenis Sampah</th>
                            <th class="text-center min-w-100px">MAE (ton)</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        <tr>
                            <td class="">Sampah Organik</td>
                            <td class="text-center">{{ $evaluasi['regresi_organik']['mean_absolute_error'] }}</td>
                        </tr>
                        <tr>
                            <td class="">Sampah Anorganik</td>
                            <td class="text-center">{{ $evaluasi['regresi_anorganik']['mean_absolute_error'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">
                        Visualisasi Prediksi Sampah Tahun 2025
                    </span>
                </h3>
            </div>
            <div class="card-body pt-2">
                <canvas id="prediksiChart" width="600" height="400"></canvas>
            </div>
        </div>
    </div>

    {{-- <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">
                        Visualisasi Akurasi Klasifikasi
                    </span>
                </h3>
            </div>
            <div class="card-body pt-2">
                <canvas id="akurasiChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div> --}}

    <div class="col-lg-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">
                        Visualisasi Mean Absolute Error (MAE)
                    </span>
                </h3>
            </div>
            <div class="card-body pt-2">
                <canvas id="maeChart" width="600" height="400"></canvas>
            </div>
        </div>
    </div>
</div>

@section('script')
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
@endsection
@endsection
