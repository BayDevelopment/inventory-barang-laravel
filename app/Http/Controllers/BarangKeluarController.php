<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangKeluar::with([
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

        $DBarangKeluar = $query->paginate(5)->withQueryString();

        return view('admin.barang-keluar.page-barang-keluar', [
            'title' => 'Barang Keluar | Inventory Barang',
            'navlink' => 'Barang Keluar',
            'd_barangkeluar' => $DBarangKeluar,
            'kategoriList' => KategoriModel::all(), // untuk dropdown
        ]);
    }
}
