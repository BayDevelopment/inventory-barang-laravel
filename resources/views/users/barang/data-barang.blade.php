@extends('layouts.user')

@section('content_user')
    <div class="container-fluid px-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <div>
                <h1 class="fw-bold mb-0">{{ $navlink }}</h1>
                <small class="text-muted">Manajemen data barang</small>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Total Barang</h6>
                            <h3 class="fw-bold mb-0">{{ $totalBarang }}</h3>
                        </div>
                        <div class="icon-circle bg-primary text-white">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label class="form-label small text-muted">Cari Barang</label>
                            <input type="text" name="search" class="form-control" placeholder="Nama / Kode Barang"
                                value="{{ request('search') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small text-muted">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach ($kategoriList as $kat)
                                    <option value="{{ $kat->id_kategori }}"
                                        {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small text-muted">Satuan</label>
                            <select name="satuan" class="form-select">
                                <option value="">Semua Satuan</option>
                                @foreach ($satuanList as $satuan)
                                    <option value="{{ $satuan }}"
                                        {{ request('satuan') == $satuan ? 'selected' : '' }}>
                                        {{ $satuan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 d-grid">
                            <button class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $item->kode_barang }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori->kategori }}</td>
                                <td>{{ $item->kategori->satuan }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $item->stok }}</span>
                                </td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted">Data barang tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
