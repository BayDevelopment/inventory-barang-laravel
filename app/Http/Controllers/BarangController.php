<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function PageBarang(Request $request)
    {
        $query = BarangModel::with('kategori');

        // SEARCH (kode_barang / nama_barang)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%");
            });
        }

        // FILTER KATEGORI (id_kategori)
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // FILTER SATUAN (ambil dari tb_kategori.satuan)
        if ($request->filled('satuan')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('satuan', $request->satuan);
            });
        }

        $barang = $query->orderBy('id_barang', 'desc')->get();

        $data = [
            'title' => 'Data Barang | Inventory Barang',
            'navlink' => 'Data Barang',
            'barang' => $barang,
            'totalBarang' => BarangModel::count(), // untuk card jumlah semua barang
            'kategoriList' => KategoriModel::orderBy('kategori')->get(), // dropdown kategori
            'satuanList' => KategoriModel::select('satuan')->distinct()->orderBy('satuan')->pluck('satuan'), // dropdown satuan
        ];

        return view('admin.barang.page-barang', $data);
    }
}
