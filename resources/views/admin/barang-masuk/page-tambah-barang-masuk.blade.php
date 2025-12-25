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
                    @method('POST')


                    {{-- Barang --}}
                    <div class="form-floating mb-3">
                        <select class="form-select @error('id_barang') is-invalid @enderror" name="id_barang"
                            id="barangIdSet" {{ $DBarang->isEmpty() ? 'disabled' : '' }}>

                            <option value="">-- Data Barang --</option>

                            @if ($DBarang->isEmpty())
                                <option value="">Tidak ada kategori</option>
                            @else
                                @foreach ($DBarang as $DK)
                                    <option value="{{ $DK->id_barang }}">
                                        {{ $DK->kode_barang . ' - ' . $DK->nama_barang }}
                                    </option>
                                @endforeach
                            @endif

                        </select>

                        <label for="kategoriSet">Data Barang</label>

                        @error('id_barang')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- Kategori --}}
                    <div class="form-floating mb-3">
                        <select class="form-select @error('id_supplier') is-invalid @enderror" name="id_supplier"
                            id="supplierSet" {{ $DSupplier->isEmpty() ? 'disabled' : '' }}>

                            <option value="">-- Supplier --</option>

                            @if ($DSupplier->isEmpty())
                                <option value="">Tidak ada kategori</option>
                            @else
                                @foreach ($DSupplier as $DK)
                                    <option value="{{ $DK->id_supplier }}">
                                        {{ $DK->nama_supplier . ' - ' . $DK->alamat }}
                                    </option>
                                @endforeach
                            @endif

                        </select>

                        <label for="supplierSet">Supplier</label>

                        @error('id_supplier')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Tanggal Masuk --}}
                    <div class="form-floating mb-3">
                        <input type="date" name="tanggal_masuk" id="tanggalMasukSet" value="{{ old('tanggal_masuk') }}"
                            class="form-control @error('tanggal_masuk') is-invalid @enderror" placeholder="Tanggal Masuk"
                            required>
                        <label for="tanggalMasukSet">Tanggal Masuk</label>

                        @error('tanggal_masuk')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="jumlah_masuk" id="jumlahSet" value="{{ old('jumlah_masuk') }}"
                            class="form-control @error('jumlah_masuk') is-invalid @enderror" placeholder="Jumlah" required>
                        <label for="jumlahSet">Jumlah</label>

                        @error('jumlah_masuk')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Harga Beli --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="harga_beli" id="hargaBeliSet" value="{{ old('harga_beli') }}"
                            class="form-control @error('harga_beli') is-invalid @enderror" placeholder="Harga Beli"
                            required>
                        <label for="hargaBeliSet">Harga Beli</label>

                        @error('harga_beli')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <textarea name="keterangan" id="keteranganSet" class="form-control @error('keterangan') is-invalid @enderror"
                            placeholder="Harga Beli" required>{{ old('keterangan') }}</textarea>

                        <label for="keteranganSet">Keterangan</label>

                        @error('keterangan')
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
