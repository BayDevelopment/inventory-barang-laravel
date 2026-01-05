@extends('layouts.admin')

@section('content_admin')
    <div class="container px-4 mb-4">
        <h1 class="mt-4">{{ $breadcrumb }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">{{ $breadcrumb }}</li>
        </ol>

        {{-- SEARCH & FILTER --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row g-2">

                        {{-- Search --}}
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari barang / kode / keterangan..." value="{{ request('search') }}">
                        </div>

                        {{-- Dropdown Kategori --}}
                        <div class="col-md-3">
                            <select name="kategori" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($kategoriList as $kategori)
                                    <option value="{{ $kategori->id_kategori }}"
                                        {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal Masuk --}}
                        <div class="col-md-3">
                            <input type="date" name="tanggal_masuk" class="form-control"
                                value="{{ request('tanggal_masuk') }}">
                        </div>

                        {{-- Filter Button --}}
                        <div class="col-md-1 d-grid">
                            <button class="btn btn-primary" type="submit">
                                Filter
                            </button>
                        </div>

                        {{-- Reset --}}
                        <div class="col-md-1 d-grid">
                            <a href="{{ route('admin.laporan.masuk') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        {{-- TABLE DATA BARANG --}}
        <div class="card">
            <!-- Card Header -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Table Barang Keluar</h5>

                <a href="{{ route('admin.laporan.keluar-pdf') }}" class="btn btn-danger btn-sm" target="_blank">
                     <i class="fas fa-file-pdf"></i> Print PDF
                </a>
            </div>

            <!-- Card Body -->
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
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
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $item->barangById->kode_barang }}</td>
                                <td>{{ $item->barangById->kategori->kategori }}</td>
                                <td>{{ $item->tanggal_keluar }}</td>
                                <td>{{ $item->jumlah_keluar }}</td>
                                <td>{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                <td>
                                    {!! $item->keterangan
                                        ? e($item->keterangan)
                                        : '<span class="badge text-bg-secondary">Tidak ada Keterangan</span>' !!}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Data Barang Masuk tidak ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $d_barangkeluar->links() }}
                </div>
            </div>
        </div>


    </div>
@endsection
