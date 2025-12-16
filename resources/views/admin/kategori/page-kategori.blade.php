@extends('layouts.admin')

@section('content_admin')
    <div class="container px-4 mb-4">
        <h1 class="mt-4">{{ $navlink }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">{{ $navlink }}</li>
        </ol>
        <div class="justify-content-start py-2">
            <a href="{{ url('admin/kategori-tambah') }}" class="btn btn-success btn-sm py-2"><span><i
                        class="fa-solid fa-file-circle-plus"></i></span>
                Tambah</a>
        </div>

        {{-- SEARCH & FILTER --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row g-2">

                        {{-- Search --}}
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Cari Kategori..."
                                value="{{ request('search') }}">
                        </div>

                        {{-- Filter Kategori --}}
                        <div class="col-md-3">
                            <select name="kategori" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($kategori as $kat)
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
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Dibuat</th>
                            <th>Diedit</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $item->kategori }}</td>
                                <td>{{ $item->satuan }}</td>
                                <td>
                                    {{ $item->created_at->locale('id')->translatedFormat('l, d F Y H:i') }}
                                </td>
                                <td>
                                    {{ $item->updated_at->locale('id')->translatedFormat('l, d F Y H:i') }}
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('admin.kategori-edit', $item->id_kategori) }}" role="button"
                                        title="Edit">
                                        <i class="fa-solid fa-file-pen"></i>
                                    </a>
                                    <form id="delete-form-{{ $item->id_kategori }}"
                                        action="{{ route('admin.kategori-aksi-hapus', $item->id_kategori) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDeleteKategori({{ $item->id_kategori }})" title="Hapus">
                                            <i class="fa-solid fa-file-circle-xmark"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Kategori tidak ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- pagniation --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $kategori->links() }}
                </div>

            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        function confirmDeleteKategori(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data kategori akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Tidak',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection()
