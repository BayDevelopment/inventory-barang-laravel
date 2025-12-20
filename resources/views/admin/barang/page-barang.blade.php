@extends('layouts.admin')

@section('content_admin')
    <div class="container px-4 mb-4">
        <h1 class="mt-4">{{ $navlink }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">{{ $navlink }}</li>
        </ol>
        <div class="justify-content-start py-2">
            <a href="{{ url('admin/data-barang/tambah') }}" class="btn btn-success btn-sm py-2"><span><i
                        class="fa-solid fa-file-circle-plus"></i></span>
                Tambah</a>
        </div>
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
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $item)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $item->kode_barang }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori->kategori }}</td>
                                <td>{{ $item->kategori->satuan }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.data-barang-edit-page', $item->id_barang) }}" role="button" title="Edit"><i class="fa-solid fa-file-pen"></i></a>
                                     <form id="delete-barang-form-{{ $item->id_barang }}"
                                        action="{{ route('admin.data-barang-edit-aksi-delete', $item->id_barang) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDeleteBarang({{ $item->id_barang }})" title="Hapus">
                                            <i class="fa-solid fa-file-circle-xmark"></i>
                                        </button>
                                    </form>
                                </td>
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
@section('scripts')
    <script>
        function confirmDeleteBarang(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data barang akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Tidak',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-barang-form-' + id).submit();
                }
            });
        }
    </script>
@endsection()