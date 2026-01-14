@extends('layouts.admin')

@section('content_admin')
<div class="container-fluid px-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
            <h1 class="mb-0">Detail Pengguna</h1>
            <small class="text-muted">Informasi akun dan pengguna lainnya</small>
        </div>
        <a href="{{ route('admin.setting') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Detail User</li>
    </ol>

    <div class="row g-4">

        <!-- LEFT : DETAIL USER -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">

                    <div class="rounded-circle bg-dark text-white d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:90px;height:90px;font-size:32px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <h5 class="mb-0">{{ $user->name }}</h5>
                    <small class="text-muted">{{ $user->email }}</small>

                    <div class="mt-3 d-flex justify-content-center gap-2 flex-wrap">
                        <span class="badge bg-dark px-3 py-2">
                            <i class="fa-solid fa-user-shield me-1"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <hr>

                    <div class="text-start small">
                        <p><strong>Email Verified:</strong>
                            <span class="float-end {{ $user->email_verified_at ? 'text-success' : 'text-danger' }}">
                                {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y') : 'Belum' }}
                            </span>
                        </p>
                        <p><strong>Password:</strong><span class="float-end text-muted">••••••••</span></p>
                        <p><strong>Role:</strong><span class="float-end">{{ ucfirst($user->role) }}</span></p>
                        <p class="mb-0"><strong>Status:</strong>
                            <span class="float-end">
                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </span>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT : AKUN LAINNYA -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-semibold">
                    Akun Lainnya
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <span class="badge bg-dark">{{ ucfirst($item->role) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.setting-show', $item->id) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.setting-edit', $item->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Tidak ada akun lain
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
