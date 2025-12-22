@extends('layouts.admin')

@section('content_admin')
    <div class="container px-4 mb-4">
        <h1 class="mt-4">{{ $navlink }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">{{ $navlink }}</li>
        </ol>
        <div class="justify-content-start py-2">
            <a href="{{ url('admin/data-supplier/tambah') }}" class="btn btn-success btn-sm py-2"><span><i
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
                            <input type="text" name="search" class="form-control" placeholder="Cari nama supplier..."
                                value="{{ request('search') }}">
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
                            <th>Nama</th>
                            <th>Telp</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($d_supplier as $item)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $item->nama_supplier }}</td>
                                <td>{{ $item->telp }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('admin.data-supplier-edit-page', $item->id_supplier) }}"
                                        role="button" title="Edit"><i class="fa-solid fa-file-pen"></i></a>
                                    <form id="delete-supplier-form-{{ $item->id_supplier }}"
                                        action="{{ route('admin.data-barang-edit-aksi-delete', $item->id_supplier) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDeleteSupplier({{ $item->id_supplier }})" title="Hapus">
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
        function confirmDeleteSupplier(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data supplier akan dihapus permanen!',
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
