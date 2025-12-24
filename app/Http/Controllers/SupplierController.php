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
            $query->where('nama_supplier', 'like', '%' . $request->search . '%');
        }

        $D_Supplier = $query->paginate(5)->withQueryString();

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
            ->route('admin.supplier-data')
            ->with('success', 'Data Supplier berhasil ditambahkan.');
    }
    public function PageEdit($id)
    {
        $D_Edit = SupplierModel::findOrFail($id);
        $data = [
            'title' => 'Tambah Supplier',
            'navlink' => 'Tambah Supplier',
            'd_supplier' => $D_Edit
        ];

        return view('admin.supplier.page-edit-supplier', $data);
    }

    public function AksiEdit(Request $request, $id)
    {
        $DEdit = SupplierModel::findOrFail($id);

        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:100',
            'telp' => 'required|string|max:20|unique:tb_supplier,telp,' . $id . ',id_supplier',
            'alamat' => 'required|string',
        ]);

        $DEdit->update($validated);

        return redirect()
            ->route('admin.supplier-data')
            ->with('success', 'Data Supplier berhasil diperbarui.');
    }

    public function SupplierDestroy($id){
        $DEdit = SupplierModel::findOrFail($id);
        if(!$DEdit){
            return redirect()
            ->route('admin.supplier-data')
            ->with('error', 'Data Supplier tidak ditemukan.');
        }

        $DEdit->delete();
        return redirect()
            ->back()
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
