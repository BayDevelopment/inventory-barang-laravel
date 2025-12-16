@extends('layouts.admin')

@section('content_admin')
    <div class="container px-4 mb-4">

        {{-- Title --}}
        <h1 class="mt-4">{{ $navlink }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">{{ $navlink }}</li>
        </ol>

        {{-- Back Button --}}
        <div class="mb-3">
            <a href="{{ url()->previous() }}" class="btn btn-dark btn-sm">
                <i class="fa-solid fa-circle-chevron-left me-1"></i>
                Kembali
            </a>
        </div>

        {{-- Card Form --}}
        <div class="card shadow-sm">

            {{-- Card Header --}}
            <div class="card-header bg-dark text-white">
                <i class="fa-solid fa-plus me-1"></i>
                Form Kategori
            </div>

            {{-- Card Body --}}
            <div class="card-body">

                <form action="{{ route('admin.kategori-update', $d_kategori->id_kategori) }}" method="POST"
                    class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- Kategori --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="kategori" id="kategoriSet"
                            value="{{ old('kategori', $d_kategori->kategori) }}"
                            class="form-control @error('kategori') is-invalid @enderror" placeholder="Kategori" required
                            autofocus>
                        <label for="kategoriSet">Kategori</label>

                        @error('kategori')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Satuan --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="satuan" id="satuanSet" value="{{ old('satuan', $d_kategori->satuan) }}"
                            class="form-control @error('satuan') is-invalid @enderror" placeholder="Satuan" required>
                        <label for="satuanSet">Satuan</label>

                        @error('satuan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="d-grid">
                        <button class="btn btn-dark" type="submit">
                            <i class="fa-solid fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>


            </div>
        </div>

    </div>
@endsection
