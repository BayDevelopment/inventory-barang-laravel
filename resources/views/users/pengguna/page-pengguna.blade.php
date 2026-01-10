@extends('layouts.user')

@section('content_user')
    <div class="container px-4 mb-4">
        <h1 class="mt-4">{{ $navlink }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">{{ $navlink }}</li>
        </ol>
        <div class="justify-content-start py-2">
            <a href="{{ url('user/pengguna/tambah') }}" class="btn btn-success btn-sm py-2"><span><i
                        class="fa-solid fa-file-circle-plus"></i></span>
                Tambah</a>
        </div>

        {{-- SEARCH & FILTER --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row g-2">

                        {{-- Search --}}
                        <div class="col-md-8">
                            <input type="text" name="search" class="form-control" placeholder="Cari pengguna..."
                                value="{{ request('search') }}">
                        </div>

                        {{-- Button --}}
                        <div class="col-md-2 d-grid">
                            <button class="btn btn-primary" type="submit">
                                Filter
                            </button>
                        </div>

                        {{-- Reset --}}
                        <div class="col-md-2 d-grid">
                            <a href="{{ route('user.pengguna') }}" class="btn btn-secondary">
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
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Status Akun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($d_pengguna as $item)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if ($item->is_active == 1)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle"></i> Non-Aktif
                                        </span>
                                    @endif
                                </td>


                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('user.pengguna-edit', $item->id) }}"
                                        role="button" title="Edit"><i class="fa-solid fa-file-pen"></i></a>
                                    <form id="pengguna-delete-form-{{ $item->id }}"
                                        action="{{ route('user.aksi-pengguna-hapus', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDeletePengguna({{ $item->id }})" title="Hapus">
                                            <i class="fa-solid fa-file-circle-xmark"></i>
                                        </button>
                                    </form>
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
                    {{ $d_pengguna->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        function confirmDeletePengguna(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data Pengguna akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Tidak',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('pengguna-delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection()
