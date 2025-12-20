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
            <a href="{{ url('admin/data-barang') }}" class="btn btn-dark btn-sm">
                <i class="fa-solid fa-circle-chevron-left me-1"></i>
                Kembali
            </a>
        </div>

        {{-- Card Form --}}
        <div class="card shadow-sm">

            {{-- Card Header --}}
            <div class="card-header bg-dark text-white">
                <i class="fa-solid fa-plus me-1"></i>
                Form Edit Barang
            </div>

            {{-- Card Body --}}
            <div class="card-body">

                <form action="{{ route('admin.data-barang-edit-aksi',$d_barang['id_barang']) }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('PUT')
                    {{-- Kode Barang --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="kode_barang" id="kodebarangSet"
                            value="{{ old('kode_barang', $d_barang['kode_barang']) }}"
                            class="form-control @error('kode_barang') is-invalid @enderror" required readonly>
                        <label for="kategoriSet">Kode Barang</label>

                        @error('kode_barang')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="nama_barang" id="namabarangSet"
                            value="{{ old('nama_barang', $d_barang['nama_barang']) }}"
                            class="form-control @error('nama_barang') is-invalid @enderror" placeholder="Kode Barang"
                            required autofocus>
                        <label for="kategoriSet">Nama Barang</label>

                        @error('nama_barang')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="form-floating mb-3">
                        <select class="form-select @error('id_kategori') is-invalid @enderror" name="id_kategori"
                            id="kategoriSet" {{ $DataKategori->isEmpty() ? 'disabled' : '' }}>

                            <option value="">-- Kategori --</option>

                            @if ($DataKategori->isEmpty())
                                <option value="">Tidak ada kategori</option>
                            @else
                                @foreach ($DataKategori as $DK)
                                    <option value="{{ $DK->id_kategori }}"
                                        {{ old('id_kategori', $d_barang->id_kategori) == $DK->id_kategori ? 'selected' : '' }}>
                                        {{ $DK->kategori }} - {{ $DK->satuan }}
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




                    {{-- Stok --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="stok" id="stokSet" value="{{ old('stok', $d_barang['stok']) }}"
                            class="form-control @error('stok') is-invalid @enderror" placeholder="stok" required>
                        <label for="stokSet">Stok</label>

                        @error('stok')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="harga" id="hargaSet" value="{{ old('harga', $d_barang['harga']) }}"
                            class="form-control @error('harga') is-invalid @enderror" placeholder="harga" required>
                        <label for="hargaSet">Harga</label>

                        @error('harga')
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
