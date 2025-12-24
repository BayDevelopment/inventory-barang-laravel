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
            <a href="{{ url('admin/data-barang-masuk') }}" class="btn btn-dark btn-sm">
                <i class="fa-solid fa-circle-chevron-left me-1"></i>
                Kembali
            </a>
        </div>

        {{-- Card Form --}}
        <div class="card shadow-sm">

            {{-- Card Header --}}
            <div class="card-header bg-dark text-white">
                <i class="fa-solid fa-plus me-1"></i>
                Form Barang Masuk
            </div>

            {{-- Card Body --}}
            <div class="card-body">

                <form action="{{ route('admin.barang-masuk-aksi-tambah') }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf
                    {{-- Kode Barang --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="kode_barang" id="kodebarangSet" value="{{ old('kode_barang',$DKodeBarang) }}"
                            class="form-control @error('kode_barang') is-invalid @enderror" placeholder="kode_barang"
                            required autofocus>
                        <label for="kodebarangSet">kode_barang</label>

                        @error('kode_barang')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="form-floating mb-3">
                        <select class="form-select @error('id_kategori') is-invalid @enderror" name="id_kategori"
                            id="kategoriSet" {{ $DKategori->isEmpty() ? 'disabled' : '' }}>

                            <option value="">-- Kategori --</option>

                            @if ($DKategori->isEmpty())
                                <option value="">Tidak ada kategori</option>
                            @else
                                @foreach ($DKategori as $DK)
                                    <option value="{{ $DK->id_kategori }}">
                                        {{ $DK->kategori . ' - ' . $DK->satuan }}
                                    </option>
                                @endforeach
                            @endif

                        </select>

                        <label for="kategoriSet">Kategori</label>

                        @error('id_kategori')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Tanggal Masuk --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="tanggal_masuk" id="satuanSet" value="{{ old('tanggal_masuk') }}"
                            class="form-control @error('tanggal_masuk') is-invalid @enderror" placeholder="Tanggal Masuk" required>
                        <label for="satuanSet">Tanggal Masuk</label>

                        @error('tanggal_masuk')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="d-grid">
                        <button class="btn btn-dark" type="submit">
                            <i class="fa-solid fa-save me-1"></i>
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
