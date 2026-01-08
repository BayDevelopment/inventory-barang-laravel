@extends('layouts.admin')
@section('content_admin')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <!-- Card Statistik -->
        <div class="row">
            <!-- Data Barang -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card text-white bg-dark h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-boxes fa-2x"></i>
                            <span class="ms-2">Data Barang</span>
                        </div>
                        <div class="fs-3">{{ $CountBarang }}</div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a class="small text-white stretched-link" href="{{ route('admin.data-barang') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <!-- Barang Masuk -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card text-dark bg-light h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-arrow-down fa-2x"></i>
                            <span class="ms-2">Barang Masuk</span>
                        </div>
                        <div class="fs-3">{{ $CountBarangMasuk }}</div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a class="small text-dark stretched-link" href="{{ route('admin.barang-masuk-data') }}">View
                            Details</a>
                        <div class="small text-dark"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <!-- Barang Keluar -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card text-white bg-dark h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-arrow-up fa-2x"></i>
                            <span class="ms-2">Barang Keluar</span>
                        </div>
                        <div class="fs-3">{{ $CountBarangKeluar }}</div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a class="small text-white stretched-link" href="{{ route('admin.barang-keluar-data') }}">View
                            Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <!-- Pengguna -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card text-dark bg-light h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-users fa-2x"></i>
                            <span class="ms-2">Pengguna</span>
                        </div>
                        <div class="fs-3">{{ $CountPengguna }}</div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a class="small text-dark stretched-link" href="#">View Details</a>
                        <div class="small text-dark"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <!-- Area Chart Barang Masuk & Keluar -->
            <div class="col-xl-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Barang Masuk & Keluar
                    </div>
                    <div class="card-body">
                        <canvas id="areaChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bar Chart Pengguna & Data Barang -->
            <div class="col-xl-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Pengguna & Barang
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data Chart - Contoh, bisa diganti dinamis dari controller
        const areaCtx = document.getElementById('areaChart').getContext('2d');
        const areaChart = new Chart(areaCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                labels: @json($chartMonths),
                datasets: [{
                    label: 'Barang Masuk',
                    data: @json($chartMasuk),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Barang Keluar',
                    data: @json($chartKeluar),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Data Barang', 'Pengguna'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $CountBarang }}, {{ $CountPengguna }}],
                    backgroundColor: ['rgba(75, 192, 192, 0.7)', 'rgba(255, 206, 86, 0.7)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
