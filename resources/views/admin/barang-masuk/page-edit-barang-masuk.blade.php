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

                <form action="{{ route('admin.barang-masuk-aksi-edit', $BM['id_barang_masuk']) }}" method="POST"
                    class="needs-validation" novalidate>

                    @csrf
                    @method('PUT')

                    {{-- Barang --}}
                    <div class="form-floating mb-3">
                        <select name="id_barang" id="barangIdSet"
                            class="form-select @error('id_barang') is-invalid @enderror"
                            {{ $DBarang->isEmpty() ? 'disabled' : '' }}>
                            <option value="">-- Data Barang --</option>

                            @foreach ($DBarang as $DK)
                                <option value="{{ $DK->id_barang }}" data-harga="{{ $DK->harga }}"
                                    {{ old('id_barang', $BM->id_barang) == $DK->id_barang ? 'selected' : '' }}>
                                    {{ $DK->kode_barang }} - {{ $DK->nama_barang }}
                                </option>
                            @endforeach
                        </select>

                        @error('id_barang')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Supplier --}}
                    <div class="form-floating mb-3">
                        <select name="id_supplier" id="supplierSet"
                            class="form-select @error('id_supplier') is-invalid @enderror"
                            {{ $DSupplier->isEmpty() ? 'disabled' : '' }}>
                            <option value="">-- Supplier --</option>

                            @foreach ($DSupplier as $S)
                                <option value="{{ $S->id_supplier }}"
                                    {{ old('id_supplier', $BM->id_supplier) == $S->id_supplier ? 'selected' : '' }}>
                                    {{ $S->nama_supplier }} - {{ $S->alamat }}
                                </option>
                            @endforeach
                        </select>

                        @error('id_supplier')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Masuk --}}
                    <div class="form-floating mb-3">
                        <input type="datetime-local" name="tanggal_masuk" id="tanggalMasukSet"
                            value="{{ old('tanggal_masuk', \Carbon\Carbon::parse($BM->tanggal_masuk)->format('Y-m-d\TH:i')) }}"
                            class="form-control @error('tanggal_masuk') is-invalid @enderror" required>
                        <label for="tanggalMasukSet">Tanggal Masuk</label>

                        @error('tanggal_masuk')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Jumlah --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="jumlah_masuk" id="jumlahSet"
                            value="{{ old('jumlah_masuk', $BM->jumlah_masuk) }}"
                            class="form-control @error('jumlah_masuk') is-invalid @enderror" placeholder="Jumlah" required>
                        <label for="jumlahSet">Jumlah</label>

                        @error('jumlah_masuk')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Harga Beli --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="harga_beli" id="hargaBeliSet"
                            value="{{ old('harga_beli', $BM->harga_beli) }}"
                            class="form-control @error('harga_beli') is-invalid @enderror" required>
                        <label for="hargaBeliSet">Harga Beli</label>

                        @error('harga_beli')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="form-floating mb-3">
                        <textarea name="keterangan" id="keteranganSet" class="form-control @error('keterangan') is-invalid @enderror"
                            placeholder="Keterangan" rows="3" required>{{ old('keterangan', $BM->keterangan) }}</textarea>

                        <label for="keteranganSet">Keterangan</label>

                        @error('keterangan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark">
                            <i class="fa-solid fa-save me-1"></i>
                            Simpan
                        </button>
                    </div>

                </form>


            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        function setHargaDariBarang() {
            const select = document.getElementById('barangIdSet');
            const inputHarga = document.getElementById('hargaBeliSet');
            if (!select || !inputHarga) return;

            const opt = select.options[select.selectedIndex];
            // isi dari data-harga (master barang)
            inputHarga.value = opt?.dataset?.harga || inputHarga.value || '';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Optional: kalau kamu mau langsung mengikuti master barang saat load, uncomment:
            // setHargaDariBarang();
        });

        document.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'barangIdSet') {
                setHargaDariBarang();
            }
        });
    </script>
@endsection
