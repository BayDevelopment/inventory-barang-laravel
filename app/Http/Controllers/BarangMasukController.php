<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use App\Models\KategoriModel;

class BarangMasukController extends Controller
{
    public function index()
    {
        $DBarangMasuk = BarangMasuk::with(['barang', 'supplier'])
            ->paginate(10); //gunakan ini jika ada relasi belongsto di model BarangMasuk ( mengambil data relasi agar tidak berulang)
        $data = [
            'title' => 'Barang Masuk | Inventory Barang',
            'navlink' => 'Barang Masuk',
            'd_barangmasuk' => $DBarangMasuk
        ];
        return view('admin.barang-masuk.page-barang-masuk', $data);
    }

    public function PageTambahBMasuk()
    {
        $lastBarang = BarangMasuk::orderBy('kode_barang', 'desc')->first();

        if ($lastBarang) {
            $lastNumber = (int) substr($lastBarang->kode_barang, 3); // ambil 001
            $newNumber = $lastNumber + 1;
            $kodeBarang = 'BRG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $kodeBarang = 'BRG001';
        }
        $DataKategori = KategoriModel::all();

        $data = [
            'title' => 'Tambah Barang Masuk | Inventory Barang',
            'navlink' => 'Tambah Barang Masuk',
            'DKodeBarang' => $kodeBarang,
            'DKategori' => $DataKategori
        ];
        return view('admin.barang-masuk.page-tambah-barang-masuk', $data);
    }
}
