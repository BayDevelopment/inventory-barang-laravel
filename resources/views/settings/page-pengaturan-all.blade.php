@extends('layouts.admin')

@section('content_admin')
    <div class="container-fluid px-4">

        <!-- PAGE HEADER -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div>
                <h1 class="mb-0">Profile Settings</h1>
                <small class="text-muted">Kelola informasi akun dan keamanan</small>
            </div>
        </div>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>

        <div class="row g-4 mb-4">

            <!-- PROFILE CARD -->
            <div class="col-xl-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">

                        <div class="mb-3">
                            <div class="rounded-circle bg-dark text-white d-inline-flex align-items-center justify-content-center"
                                style="width:80px;height:80px;font-size:28px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </div>

                        <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                        <small class="text-muted">{{ auth()->user()->email }}</small>

                        <div class="mt-3 d-flex justify-content-center gap-2">
                            <span class="badge bg-dark px-3 py-2">
                                <i class="fa-solid fa-user-shield me-1"></i>
                                {{ auth()->user()->role === 'admin' ? 'Admin' : 'User' }}
                            </span>
                            <span class="badge {{ auth()->user()->is_active ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                {{ auth()->user()->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>

                        <hr>

                        <div class="text-start small">
                            <p class="mb-1"><strong>User ID:</strong> {{ auth()->user()->id }}</p>
                            <p class="mb-1">
                                <strong>Email Verified:</strong>
                                <span class="{{ auth()->user()->email_verified_at ? 'text-success' : 'text-danger' }}">
                                    {{ auth()->user()->email_verified_at ? 'Yes' : 'No' }}
                                </span>
                            </p>
                            <p class="mb-0">
                                <strong>Bergabung:</strong>
                                {{ auth()->user()->created_at->format('d M Y') }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- SETTINGS -->
            <div class="col-xl-8">

                <!-- TABS -->
                <ul class="nav nav-pills gap-2 mb-3">
                    <li class="nav-item flex-fill">
                        <button class="nav-link active w-100" data-bs-toggle="pill" data-bs-target="#profileTab">
                            <i class="fa-solid fa-user me-1"></i> Profile
                        </button>
                    </li>
                    <li class="nav-item flex-fill">
                        <button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#passwordTab">
                            <i class="fa-solid fa-lock me-1"></i> Security
                        </button>
                    </li>
                </ul>

                <div class="tab-content">

                    <!-- PROFILE TAB -->
                    <div class="tab-pane fade show active" id="profileTab">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white fw-semibold">
                                Informasi Profil
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.setting-profile') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', auth()->user()->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', auth()->user()->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button class="btn btn-dark w-100">
                                        <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- PASSWORD TAB -->
                    <div class="tab-pane fade" id="passwordTab">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white fw-semibold">
                                Keamanan Akun
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.setting-security') }}">
                                    @csrf

                                    @foreach ([
            'current_password' => 'Password Lama',
            'password' => 'Password Baru',
            'password_confirmation' => 'Konfirmasi Password',
        ] as $field => $label)
                                        <div class="mb-3">
                                            <label class="form-label">{{ $label }}</label>
                                            <div class="input-group">
                                                <input type="password" id="{{ $field }}" name="{{ $field }}"
                                                    class="form-control @error($field) is-invalid @enderror">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="togglePassword('{{ $field }}', this)">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </div>
                                            @error($field)
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    @endforeach

                                    <button class="btn btn-dark w-100">
                                        <i class="fa-solid fa-key me-1"></i> Update Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- USER TABLE -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-semibold">
                        Daftar Pengguna
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($d_User as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
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
                                            <button class="btn btn-sm btn-danger"
                                                onclick="confirmDeleteUserSet({{ $item->id }})">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Tidak ada data user
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
