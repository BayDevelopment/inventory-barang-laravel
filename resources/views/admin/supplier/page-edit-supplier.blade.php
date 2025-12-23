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
            <a href="{{ url('admin/data-supplier') }}" class="btn btn-dark btn-sm">
                <i class="fa-solid fa-circle-chevron-left me-1"></i>
                Kembali
            </a>
        </div>

        {{-- Card Form --}}
        <div class="card shadow-sm">

            {{-- Card Header --}}
            <div class="card-header bg-dark text-white">
                <i class="fa-solid fa-plus me-1"></i>
                Form Edit Supplier
            </div>

            {{-- Card Body --}}
            <div class="card-body">

                <form action="{{ route('admin.supplier-edit-aksi',$d_supplier->id_supplier) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    {{-- nama supplier --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="nama_supplier" id="namaSupplier" value="{{ old('nama_supplier', $d_supplier['nama_supplier']) }}"
                            class="form-control @error('nama_supplier') is-invalid @enderror" placeholder="Nama Supplier"
                            required>
                        <label for="namaSupplier">Nama Supplier</label>

                        @error('nama_supplier')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="telp" id="telpSet" value="{{ old('telp', $d_supplier['telp']) }}"
                            class="form-control @error('telp') is-invalid @enderror" placeholder="Kode Barang" required>
                        <label for="telpSet">No Telp</label>

                        @error('telp')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Alamat --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="alamat" id="alamatSet" value="{{ old('alamat', $d_supplier['alamat']) }}"
                            class="form-control @error('alamat') is-invalid @enderror" placeholder="stok" required>
                        <label for="alamatSet">Alamat</label>

                        @error('alamat')
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
