@extends('layouts.user')

@section('content_user')
<div class="container-fluid px-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="fw-bold mb-0">{{ $navlink }}</h1>
            <small class="text-muted">Input dan monitoring barang keluar</small>
        </div>
        <a href="{{ url($role . '/data-barang-keluar/tambah') }}" class="btn btn-success">
            <i class="fa-solid fa-file-circle-plus me-1"></i> Tambah Barang Keluar
        </a>
    </div>

    {{-- Statistik Card --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Total Barang Keluar</h6>
                        <h3 class="fw-bold mb-0">{{ $d_barangkeluar->total() }}</h3>
                    </div>
                    <div class="icon-circle bg-primary text-white">
                        <i class="fas fa-box-open"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="">
                <div class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label class="form-label small text-muted">Cari Barang</label>
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari nama / kode / keterangan" value="{{ request('search') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small text-muted">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoriList as $kategori)
                                <option value="{{ $kategori->id_kategori }}"
                                    {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                    {{ $kategori->kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>

                    <div class="col-md-2 d-grid">
                        <a href="{{ url($role . '/data-barang-keluar') }}" class="btn btn-secondary">Reset</a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Table Barang Keluar --}}
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Kategori</th>
                        <th>Tanggal Keluar</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($d_barangkeluar as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $item->barangById->kode_barang }}</td>
                            <td>{{ $item->barangById->kategori->kategori }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d M Y') }}</td>
                            <td>{{ $item->jumlah_keluar }}</td>
                            <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            <td>
                                {!! $item->keterangan 
                                    ? e($item->keterangan) 
                                    : '<span class="badge bg-secondary">Tidak ada keterangan</span>' !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted">Data barang keluar tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $d_barangkeluar->links() }}
    </div>

</div>
@endsection

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

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
