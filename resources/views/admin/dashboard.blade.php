@extends('layouts.admin')
@section('content_admin')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="row">
        <!-- Data Barang -->
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background-color: #343a40;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-boxes fa-2x"></i>
                        <span class="ms-2">Data Barang</span>
                    </div>
                    <div class="fs-3">0</div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <!-- Barang Masuk -->
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background-color: silver; color: #000;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-arrow-down fa-2x"></i>
                        <span class="ms-2">Barang Masuk</span>
                    </div>
                    <div class="fs-3">0</div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-dark stretched-link" href="#">View Details</a>
                    <div class="small text-dark"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <!-- Barang Keluar -->
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background-color: #343a40;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-arrow-up fa-2x"></i>
                        <span class="ms-2">Barang Keluar</span>
                    </div>
                    <div class="fs-3">0</div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <!-- Pengguna -->
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background-color: silver; color: #000;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-users fa-2x"></i>
                        <span class="ms-2">Pengguna</span>
                    </div>
                    <div class="fs-3">0</div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-dark stretched-link" href="#">View Details</a>
                    <div class="small text-dark"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Area Chart Example
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Bar Chart Example
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>
</div>
@endsection
