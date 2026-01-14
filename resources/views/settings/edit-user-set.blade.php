@extends('layouts.admin')

@section('content_admin')
    <div class="container-fluid px-4">

        <!-- PAGE HEADER -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div>
                <h1 class="mb-0">Edit Pengguna</h1>
                <small class="text-muted">Perbarui data akun pengguna</small>
            </div>
            <a href="{{ route('admin.setting') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Edit User</li>
        </ol>

        <div class="row g-4">

            <!-- LEFT : FORM EDIT USER -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-semibold">
                        Form Edit User
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.setting-update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- NAME -->
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- EMAIL -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ROLE -->
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror">
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User
                                    </option>
                                </select>
                                @error('role')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- STATUS -->
                            <div class="mb-3">
                                <label class="form-label">Status Akun</label>
                                <select name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                                    <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="0" {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>
                                        Nonaktif</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PASSWORD (opsional) -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Password
                                </label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Kosongkan jika ingin mengubah">
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('password', this)">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- CONFIRM PASSWORD -->
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Konfirmasi password baru">
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePassword('password_confirmation', this)">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button class="btn btn-dark w-100">
                                <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- RIGHT : AKUN LAINNYA -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-semibold">Akun Lainnya</div>

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
                                        <td><span class="badge bg-dark">{{ ucfirst($item->role) }}</span></td>
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

                    <div class="card-footer bg-white">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
