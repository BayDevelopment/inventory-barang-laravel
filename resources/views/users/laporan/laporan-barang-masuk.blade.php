@extends('layouts.user')

@section('content_user')
    <div class="container-fluid px-4 mb-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div>
                <h1 class="fw-bold mb-0">{{ $breadcrumb }}</h1>
                <small class="text-muted">Monitoring dan laporan barang masuk</small>
            </div>
            <a href="{{ route('user.laporan.masuk-pdf') }}" class="btn btn-danger" id="btnPrintPDF">
                <i class="fas fa-file-pdf me-1"></i> Print PDF
            </a>
        </div>

        {{-- Search & Filter --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row g-3 align-items-end">

                        {{-- Search --}}
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Cari Barang</label>
                            <input type="text" name="search" class="form-control"
                                placeholder="Nama / kode / keterangan..." value="{{ request('search') }}">
                        </div>

                        {{-- Kategori --}}
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($kategoriList as $kategori)
                                    <option value="{{ $kategori->id_kategori }}"
                                        {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal Masuk --}}
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control"
                                value="{{ request('tanggal_masuk') }}">
                        </div>

                        {{-- Buttons --}}
                        <div class="col-md-1 d-grid">
                            <button class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-1 d-grid">
                            <a href="{{ route('user.laporan.masuk') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Kategori</th>
                            <th>Tanggal Masuk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($d_barangmasuk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td class="fw-semibold">{{ $item->barangById->kode_barang }}</td>
                                <td>{{ $item->barangById->kategori->kategori }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }}</td>
                                <td>{{ $item->jumlah_masuk }}</td>
                                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                <td>
                                    {!! $item->keterangan ? e($item->keterangan) : '<span class="badge bg-secondary">Tidak ada keterangan</span>' !!}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">Data Barang Masuk tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $d_barangmasuk->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection

@section('styles')
    <style>
        .card {
            border-radius: 12px;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.35em 0.6em;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Konfirmasi sebelum membuka PDF
        document.getElementById('btnPrintPDF')?.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin mencetak laporan ini?')) {
                e.preventDefault();
            }
        });
    </script>
@endsection
