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
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Kategori</th>
                            <th>Tanggal Masuk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($d_barangmasuk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $item->barangById->kode_barang }}</td>
                                <td>{{ $item->barangById->kategori->kategori }}</td>
                                <td>{{ $item->tanggal_masuk }}</td>
                                <td>{{ $item->jumlah_masuk }}</td>
                                <td>{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                <td>
                                    {!! $item->keterangan
                                        ? e($item->keterangan)
                                        : '<span class="badge text-bg-secondary">Tidak ada Keterangan</span>' !!}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Data Barang Masuk tidak ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $d_barangmasuk->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection
