@extends('layouts.admin')

@section('content_admin')
    <div class="container-fluid px-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <div>
                <h1 class="fw-bold mb-0">Dashboard</h1>
                <small class="text-muted">Ringkasan aktivitas sistem</small>
            </div>
        </div>

        {{-- Statistik Cards --}}
        <div class="row g-4">

            {{-- Data Barang --}}
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Data Barang</h6>
                            <h3 class="fw-bold mb-0">{{ $CountBarang }}</h3>
                        </div>
                        <div class="icon-circle bg-dark text-white">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('admin.data-barang') }}" class="text-decoration-none small">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Barang Masuk --}}
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Barang Masuk</h6>
                            <h3 class="fw-bold mb-0">{{ $CountBarangMasuk }}</h3>
                        </div>
                        <div class="icon-circle bg-success text-white">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('admin.barang-masuk-data') }}" class="text-decoration-none small">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Barang Keluar --}}
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Barang Keluar</h6>
                            <h3 class="fw-bold mb-0">{{ $CountBarangKeluar }}</h3>
                        </div>
                        <div class="icon-circle bg-danger text-white">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('admin.barang-keluar-data') }}" class="text-decoration-none small">
                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Pengguna --}}
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Pengguna</h6>
                            <h3 class="fw-bold mb-0">{{ $CountPengguna }}</h3>
                        </div>
                        <div class="icon-circle bg-primary text-white">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a class="small text-decoration-none" href="{{ route('admin.pengguna') }}">
                            View Details <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="row g-4 mt-2">

            {{-- Area Chart: Barang Masuk & Keluar --}}
            <div class="col-xl-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-semibold">
                        <i class="fas fa-chart-line me-2 text-primary"></i>
                        Barang Masuk & Keluar
                    </div>
                    <div class="card-body">
                        <canvas id="areaChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            {{-- Bar Chart: Pengguna & Data Barang --}}
            <div class="col-xl-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-semibold">
                        <i class="fas fa-chart-bar me-2 text-success"></i>
                        Pengguna & Barang
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" height="120"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

{{-- Custom CSS --}}
@section('styles')
    <style>
        .icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .card {
            border-radius: 12px;
        }
    </style>
@endsection

{{-- Chart.js Scripts --}}
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ====== Area Chart ======
            const areaCtx = document.getElementById('areaChart').getContext('2d');
            const areaChart = new Chart(areaCtx, {
                type: 'line',
                data: {
                    labels: @json($chartMonths),
                    datasets: [{
                            label: 'Barang Masuk',
                            data: @json($chartMasuk),
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Barang Keluar',
                            data: @json($chartKeluar),
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        },
                        y: {
                            display: true,
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah'
                            }
                        }
                    }
                }
            });

            // ====== Bar Chart ======
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
                        borderWidth: 1,
                        borderRadius: 6
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
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Kategori'
                            }
                        }
                    }
                }
            });

        });
    </script>
@endsection
