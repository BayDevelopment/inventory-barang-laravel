<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    {{-- Kalau kamu pakai Bootstrap via Vite, cukup @vite --}}
    @vite(['resources/js/app.js'])

    {{-- Kalau kamu pakai CDN, komentari @vite di atas lalu pakai ini:
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    --}}
</head>

<body class="bg-light">

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
        <div class="row w-100 shadow bg-white rounded-4 overflow-hidden" style="max-width: 980px;">

            {{-- KIRI: Gambar --}}
            <div class="col-md-6 d-none d-md-block p-0">
                <div class="h-100 w-100"
                    style="
        background-image: url('{{ asset('img/inventory-img-login.svg') }}');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        min-height: 520px;
    ">
                </div>
            </div>

            {{-- KANAN: Form --}}
            <div class="col-12 col-md-6 p-4 p-md-5">
                <h3 class="fw-bold mb-2">Masuk</h3>
                <p class="text-muted mb-4">Login menggunakan email dan password.</p>

                <form method="POST" action="{{ route('aksi.login') }}" class="needs-validation" novalidate>
                    @csrf

                    {{-- EMAIL --}}
                    <div class="form-floating mb-3">
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com"
                            required autofocus>
                        <label for="email">Email</label>

                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="form-floating mb-2">
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                            required>
                        <label for="password">Password</label>

                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember_token" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        {{-- Link lupa password --}}
                        @if (Route::has('forgot.password'))
                            <a class="link-primary text-decoration-none small" href="{{ route('forgot.password') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">
                        Login
                    </button>
                </form>

            </div>

        </div>
    </div>

    {{-- Kalau pakai CDN:
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
--}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any() && !session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Terjadi kesalahan',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
        </script>
    @endif

    {{-- LOGIN GAGAL --}}
    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Login gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif

    {{-- STATUS / SUCCESS --}}
    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        </script>
    @endif
