<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function PageKategori(Request $request)
    {
        // ambil data kategori (opsional: hitung jumlah barang per kategori)
        $query = KategoriModel::withCount('barang');

        // SEARCH (kategori / satuan)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kategori', 'like', "%{$search}%")
                    ->orWhere('satuan', 'like', "%{$search}%")
                    ->orWhere('id_kategori', 'like', "%{$search}%"); // optional kalau mau cari by id
            });
        }

        // FILTER SATUAN
        if ($request->filled('satuan')) {
            $query->where('satuan', $request->satuan);
        }

        // OPTIONAL: filter kategori tertentu by id_kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        $kategori = $query->orderBy('id_kategori', 'desc')
            ->paginate(5)                 // jumlah per halaman
            ->withQueryString();           // biar filter/search ikut kebawa

        $data = [
            'title' => 'Data Kategori | Inventory Barang',
            'navlink' => 'Data Kategori',
            'kategori' => $kategori,

            'totalKategori' => KategoriModel::count(),
            'satuanList' => KategoriModel::select('satuan')
                ->distinct()
                ->orderBy('satuan')
                ->pluck('satuan'),
        ];

        return view('admin.kategori.page-kategori', $data);
    }

    public function PageInsert()
    {
        $data = [
            'title' => 'Insert kategori | Inventory Barang',
            'navlink' => 'Tambah Kategori',
        ];

        return view('admin.kategori.page-tambah', $data);
    }

    // ✅ INI YANG DIPANGGIL FORM action="{{ route('admin.kategori-aksi') }}"
    public function KategoriAksi(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'kategori' => 'required|string|max:100|unique:tb_kategori,kategori',
            'satuan' => 'required|string|max:50',
        ], [
            'kategori.required' => 'Kategori wajib diisi.',
            'kategori.unique' => 'Kategori sudah ada.',
            'satuan.required' => 'Satuan wajib diisi.',
        ]);

        // simpan
        KategoriModel::create([
            'kategori' => $validated['kategori'],
            'satuan' => $validated['satuan'],
        ]);

        // redirect (ubah ke route list kategori kamu)
        return redirect()
            ->route('admin.kategori') // ganti kalau nama route list kamu beda
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function KategoriDestroy($id)
    {
        $kategori = KategoriModel::findOrFail($id);

        // ❗ CEK: apakah kategori masih dipakai di tabel barang
        if ($kategori->barang()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh barang.');
        }

        $kategori->delete();

        return redirect()
            ->back()
            ->with('success', 'Kategori berhasil dihapus.');
    }

    public function PageEdit($id)
    {
        $kategori = KategoriModel::find($id);

        // ❌ jika data tidak ditemukan
        if (! $kategori) {
            return redirect()
                ->route('admin.kategori')
                ->with('error', 'Data tidak ditemukan');
        }

        // ✅ jika data ditemukan
        return view('admin.kategori.page-edit', [
            'title' => 'Edit Kategori | Inventory Barang',
            'navlink' => 'Edit Kategori',
            'd_kategori' => $kategori,
        ]);
    }

    public function KategoriAksiUpdate(Request $request, $id)
    {
        $kategori = KategoriModel::findOrFail($id);

        // validasi (unique: kecualikan id yang sedang diedit)
        $validated = $request->validate([
            'kategori' => 'required|string|max:100|unique:tb_kategori,kategori,'.$id.',id_kategori',
            'satuan' => 'required|string|max:50',
        ], [
            'kategori.required' => 'Kategori wajib diisi.',
            'kategori.unique' => 'Kategori sudah ada.',
            'satuan.required' => 'Satuan wajib diisi.',
        ]);

        // update
        $kategori->update([
            'kategori' => $validated['kategori'],
            'satuan' => $validated['satuan'],
        ]);

        return redirect()
            ->route('admin.kategori')
            ->with('success', 'Kategori berhasil diperbaharui.');
    }
}
