@extends('layouts.admin')

@section('content_admin')
    <div class="container px-4 mb-4">
        <h1 class="mt-4">{{ $navlink }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">{{ $navlink }}</li>
        </ol>

        {{-- CARD JUMLAH BARANG --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3 fs-1 text-primary">
                            📦
                        </div>
                        <div>
                            <h6 class="mb-0">Data Barang</h6>
                            <h4 class="mb-0">{{ $totalBarang }} item</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEARCH & FILTER --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row g-2">

                        {{-- Search --}}
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari nama / kode barang..." value="{{ request('search') }}">
                        </div>

                        {{-- Filter Kategori --}}
                        <div class="col-md-3">
                            <select name="kategori" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($kategoriList as $kat)
                                    <option value="{{ $kat->id_kategori }}"
                                        {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Satuan --}}
                        <div class="col-md-3">
                            <select name="satuan" class="form-select">
                                <option value="">-- Semua Satuan --</option>
                                @foreach ($satuanList as $satuan)
                                    <option value="{{ $satuan }}"
                                        {{ request('satuan') == $satuan ? 'selected' : '' }}>
                                        {{ $satuan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Button --}}
                        <div class="col-md-2 d-grid">
                            <button class="btn btn-primary" type="submit">
                                Filter
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE DATA BARANG --}}
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
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
                                <td>{{ $item->kode_barang }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori->kategori }}</td>
                                <td>{{ $item->kategori->satuan }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Data barang tidak ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
