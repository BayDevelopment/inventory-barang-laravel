@extends('layouts.admin')

@section('content_admin')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Profile Settings</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>

        <div class="row">

            <!-- PROFILE CARD -->
            <div class="col-xl-4 col-md-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">

                        <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                        <small class="text-muted">{{ auth()->user()->email }}</small>

                        <div class="mt-3">
                            <span class="badge bg-dark">
                                @if (auth()->user()->role === 'admin')
                                    <i class="fa-brands fa-black-tie me-1"></i> Admin
                                @else
                                    <i class="fa-solid fa-user me-1"></i> User
                                @endif
                            </span>
                            <span class="badge {{ auth()->user()->is_active ? 'bg-success' : 'bg-danger' }}">
                                @if (auth()->user()->is_active)
                                    <i class="fa-solid fa-circle-check me-1"></i> Aktif
                                @else
                                    <i class="fa-solid fa-circle-xmark me-1"></i> Nonaktif
                                @endif
                            </span>

                        </div>

                        <hr>

                        <div class="text-start">
                            <p class="mb-1"><strong>User ID:</strong> {{ auth()->user()->id }}</p>
                            <p class="mb-1">
                                <strong>Email Verified:</strong>
                                @if (auth()->user()->email_verified_at)
                                    <span class="text-success">Yes</span>
                                @else
                                    <span class="text-danger">No</span>
                                @endif
                            </p>
                            <p class="mb-0">
                                <strong>Bergabung:</strong>
                                {{ auth()->user()->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PROFILE & PASSWORD -->
            <div class="col-xl-8 col-md-12">

                <!-- NAV PILLS -->
                <ul class="nav nav-pills mb-3 gap-2" role="tablist">
                    <li class="nav-item flex-fill">
                        <button class="nav-link active w-100" data-bs-toggle="pill" data-bs-target="#tab-profile"
                            type="button">
                            <i class="fas fa-user me-1"></i> Profile
                        </button>
                    </li>
                    <li class="nav-item flex-fill">
                        <button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#tab-password" type="button">
                            <i class="fas fa-lock me-1"></i> Password
                        </button>
                    </li>
                </ul>

                <!-- TAB CONTENT -->
                <div class="tab-content">

                    <!-- PROFILE TAB -->
                    <div class="tab-pane fade show active" id="tab-profile">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.setting-profile') }}">
                                    @csrf

                                    <!-- Nama -->
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', auth()->user()->name) }}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', auth()->user()->email) }}">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button class="btn btn-dark w-100">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- PASSWORD TAB -->
                    <div class="tab-pane fade" id="tab-password">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.setting-security') }}">
                                    @csrf

                                    <!-- Password Lama -->
                                    <div class="mb-3">
                                        <label class="form-label">Password Lama</label>
                                        <div class="input-group">
                                            <input type="password" id="current_password" name="current_password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                placeholder="Masukan password lama">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('current_password', this)">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('current_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Password Baru -->
                                    <div class="mb-3">
                                        <label class="form-label">Password Baru</label>
                                        <div class="input-group mb-1">
                                            <input type="password" id="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Masukan password baru" oninput="checkPasswordStrength()">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('password', this)">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>

                                        <!-- Password Strength Meter -->
                                        <div class="progress" style="height: 6px;">
                                            <div id="passwordStrength" class="progress-bar" role="progressbar"
                                                style="width: 0%;"></div>
                                        </div>
                                        <small id="passwordText" class="form-text"></small>

                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div class="mb-3">
                                        <label class="form-label">Konfirmasi Password</label>
                                        <div class="input-group">
                                            <input type="password" id="password_confirmation"
                                                name="password_confirmation"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                placeholder="Konfirmasi password">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('password_confirmation', this)">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button class="btn btn-dark w-100">
                                        <i class="fas fa-key me-1"></i> Update Password
                                    </button>
                                </form>
                            </div>
                        </div>
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

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const progress = document.getElementById('passwordStrength');
            const text = document.getElementById('passwordText');

            let strength = 0;

            // Hitung skor
            if (password.length >= 8) strength += 1; // panjang
            if (/[A-Z]/.test(password)) strength += 1; // huruf besar
            if (/[0-9]/.test(password)) strength += 1; // angka
            if (/[\W]/.test(password)) strength += 1; // simbol

            // Update progress bar dan text
            switch (strength) {
                case 0:
                case 1:
                    progress.style.width = '25%';
                    progress.className = 'progress-bar bg-danger';
                    text.innerText = 'Rentan';
                    break;
                case 2:
                case 3:
                    progress.style.width = '60%';
                    progress.className = 'progress-bar bg-warning';
                    text.innerText = 'Sedang';
                    break;
                case 4:
                    progress.style.width = '100%';
                    progress.className = 'progress-bar bg-success';
                    text.innerText = 'Kuat';
                    break;
            }
        }
    </script>
@endsection
