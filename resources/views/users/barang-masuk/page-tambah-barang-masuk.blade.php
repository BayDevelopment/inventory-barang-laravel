@extends('layouts.user')

@section('content_user')
    <div class="container-fluid px-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <div>
                <h1 class="fw-bold mb-0">{{ $navlink }}</h1>
                <small class="text-muted">Pastikan data yang dimasukkan benar</small>
            </div>
            <a href="{{ url($role . '/data-barang-masuk') }}" class="btn btn-secondary">
                <i class="fa-solid fa-circle-chevron-left me-1"></i> Kembali
            </a>
        </div>

        {{-- Form Card --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <i class="fa-solid fa-plus me-1"></i> Form Barang Masuk
            </div>
            <div class="card-body">

                <form action="{{ route($role . '.barang-masuk-aksi-tambah') }}" method="POST" class="needs-validation"
                    novalidate id="formBarangMasuk">
                    @csrf
                    @method('POST')

                    {{-- Barang --}}
                    <div class="form-floating mb-3">
                        <select class="form-select @error('id_barang') is-invalid @enderror" name="id_barang"
                            id="barangIdSet" {{ $DBarang->isEmpty() ? 'disabled' : '' }}>
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($DBarang as $DK)
                                <option value="{{ $DK->id_barang }}" data-harga="{{ $DK->harga }}">
                                    {{ $DK->kode_barang }} - {{ $DK->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                        <label for="barangIdSet">Data Barang</label>
                        @error('id_barang')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Supplier --}}
                    <div class="form-floating mb-3">
                        <select class="form-select @error('id_supplier') is-invalid @enderror" name="id_supplier"
                            id="supplierSet" {{ $DSupplier->isEmpty() ? 'disabled' : '' }}>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($DSupplier as $DK)
                                <option value="{{ $DK->id_supplier }}">
                                    {{ $DK->nama_supplier }} - {{ $DK->alamat }}
                                </option>
                            @endforeach
                        </select>
                        <label for="supplierSet">Supplier</label>
                        @error('id_supplier')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Masuk --}}
                    <div class="form-floating mb-3">
                        <input type="datetime-local" name="tanggal_masuk" id="tanggalMasukSet"
                            value="{{ old('tanggal_masuk', now('Asia/Jakarta')->format('Y-m-d\TH:i')) }}"
                            class="form-control @error('tanggal_masuk') is-invalid @enderror" required>
                        <label for="tanggalMasukSet">Tanggal Masuk</label>
                        @error('tanggal_masuk')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="form-floating mb-3">
                        <input type="number" name="jumlah_masuk" id="jumlahSet" value="{{ old('jumlah_masuk') }}"
                            class="form-control @error('jumlah_masuk') is-invalid @enderror" placeholder="Jumlah" required>
                        <label for="jumlahSet">Jumlah</label>
                        @error('jumlah_masuk')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Harga Beli --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="harga_beli" id="hargaBeliSet" value="{{ old('harga_beli') }}"
                            class="form-control @error('harga_beli') is-invalid @enderror" placeholder="Harga Beli"
                            required>
                        <label for="hargaBeliSet">Harga Beli</label>
                        @error('harga_beli')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="form-floating mb-3">
                        <textarea name="keterangan" id="keteranganSet" class="form-control @error('keterangan') is-invalid @enderror"
                            placeholder="Keterangan">{{ old('keterangan') }}</textarea>
                        <label for="keteranganSet">Keterangan</label>
                        @error('keterangan')
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

@section('scripts')
    <script>
        // Update harga otomatis saat pilih barang
        const selectBarang = document.getElementById('barangIdSet');
        const inputHarga = document.getElementById('hargaBeliSet');

        if (selectBarang && inputHarga) {
            selectBarang.addEventListener('change', function() {
                const opt = this.options[this.selectedIndex];
                inputHarga.value = opt?.dataset?.harga || '';
            });
        }

        // SweetAlert konfirmasi sebelum submit
        const form = document.getElementById('formBarangMasuk');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Pastikan data yang Anda masukkan benar!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, simpan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
