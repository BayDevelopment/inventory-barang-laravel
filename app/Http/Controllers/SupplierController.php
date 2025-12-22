<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = SupplierModel::query();

        // Filter berdasarkan nama supplier
        if ($request->filled('search')) {
            $query->where('nama_supplier', 'like', '%'.$request->search.'%');
        }

        $D_Supplier = $query->get();

        $data = [
            'title' => 'Data Supplier',
            'navlink' => 'Data Supplier',
            'd_supplier' => $D_Supplier,
        ];

        return view('admin.supplier.page-data-supplier', $data);
    }

    public function PageTambah()
    {
        $data = [
            'title' => 'Tambah Supplier',
            'navlink' => 'Tambah Supplier',
        ];

        return view('admin.supplier.page-tambah-supplier', $data);
    }

    public function AksiTambah(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:100',
            'telp' => 'required|string|max:20|unique:tb_supplier,telp',
            'alamat' => 'required|string',
        ]);

        SupplierModel::create($validated);

        return redirect()
            ->route('admin.page-tambah-supplier')
            ->with('success', 'Data Supplier berhasil ditambahkan.');
    }
}
