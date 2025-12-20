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

    public function PageTambahBarang()
    {
        $lastBarang = BarangModel::orderBy('kode_barang', 'desc')->first();

        if ($lastBarang) {
            $lastNumber = (int) substr($lastBarang->kode_barang, 3); // ambil 001
            $newNumber = $lastNumber + 1;
            $kodeBarang = 'BRG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $kodeBarang = 'BRG001';
        }

        $DataKategori = KategoriModel::all();

        return view('admin.barang.page-tambah-barang', [
            'title' => 'Tambah Barang | Inventory Barang',
            'navlink' => 'Tambah Barang',
            'kodebarang' => $kodeBarang,
            'DataKategori' => $DataKategori,
        ]);
    }

    public function AksiTambahBarang(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|unique:tb_barang,kode_barang',
            'nama_barang' => 'required|string|max:100',
            'id_kategori' => 'required|exists:tb_kategori,id_kategori',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        BarangModel::create($validated);

        return redirect()
            ->route('admin.data-barang')
            ->with('success', 'Barang berhasil ditambahkan.');
    }
    public function PageEditBarang($id)
    {
        $d_barang = BarangModel::findOrFail($id);
        $DataKategori = KategoriModel::all();

        return view('admin.barang.page-edit-barang', [
            'title' => 'Edit Barang | Inventory Barang',
            'navlink' => 'Edit Barang',
            'd_barang' => $d_barang,
            'DataKategori' => $DataKategori,
        ]);
    }
    public function AksiBarangEdit(Request $request, $id)
    {
        $d_barang = BarangModel::findOrFail($id);

        $validated = $request->validate([
            'kode_barang' => 'required|string|unique:tb_barang,kode_barang,' . $d_barang->id_barang . ',id_barang',
            'nama_barang' => 'required|string|max:100',
            'id_kategori' => 'required|exists:tb_kategori,id_kategori',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $d_barang->update($validated);

        return redirect()
            ->route('admin.data-barang')
            ->with('success', 'Barang berhasil diperbarui.');
    }
    public function BarangDestroy($id)
    {
        $d_barang = BarangModel::findOrFail($id);

        // // ❗ CEK: apakah kategori masih dipakai di tabel barang
        // if ($d_barang->barang()->count() > 0) {
        //     return redirect()
        //         ->back()
        //         ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh barang.');
        // }

        $d_barang->delete();

        return redirect()
            ->back()
            ->with('success', 'Barang berhasil dihapus.');
    }
}
