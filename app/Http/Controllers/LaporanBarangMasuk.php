<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use App\Models\KategoriModel;

class LaporanBarangMasuk extends Controller
{
    public function index(Request $request)
    {
        $query = BarangMasuk::with([
            'barangById.kategori',
            'supplierById',
        ]);

        // 🔎 SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('barangById', function ($qb) use ($search) {
                        $qb->where('nama_barang', 'like', "%{$search}%")
                            ->orWhere('kode_barang', 'like', "%{$search}%");
                    });
            });
        }

        // 🧩 FILTER KATEGORI
        if ($request->filled('kategori')) {
            $query->whereHas('barangById', function ($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // 📅 FILTER TANGGAL MASUK
        if ($request->filled('tanggal_masuk')) {
            $query->where('tanggal_masuk', $request->tanggal_masuk);
        }

        // urutkan terbaru
        $query->orderBy('tanggal_masuk', 'desc');

        $DBarangMasuk = $query->paginate(5)->withQueryString();

        return view('admin.laporan.laporan-barang-masuk', [
            'title' => 'Laporan Barang Masuk | Inventory Barang',
            'navlink' => 'laporan_masuk',
            'breadcrumb' => 'Laporan Barang Masuk',
            'd_barangmasuk' => $DBarangMasuk,
            'kategoriList' => KategoriModel::all(),
        ]);
    }
}
