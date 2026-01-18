<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\KategoriModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanBarangKeluar extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::user()->role; // Ambil role (admin / user)

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

        // 📅 FILTER TANGGAL KELUAR
        if ($request->filled('tanggal_keluar')) {
            $query->where('tanggal_keluar', $request->tanggal_keluar);
        }

        // Urutkan terbaru
        $query->orderBy('tanggal_keluar', 'desc');

        $DBarangKeluar = $query->paginate(5)->withQueryString();

        // Pilih view sesuai role
        if ($role === 'admin') {
            $view = 'admin.laporan.laporan-barang-keluar';
        } else { // user
            $view = 'users.laporan.laporan-barang-keluar';
        }

        return view($view, [
            'title' => 'Laporan Barang Keluar | Inventory Barang',
            'navlink' => 'laporan_keluar',
            'breadcrumb' => 'Laporan Barang Keluar',
            'd_barangkeluar' => $DBarangKeluar,
            'kategoriList' => KategoriModel::all(),
        ]);
    }

    public function printPDF()
    {
        $role = Auth::user()->role;

        $Data = BarangKeluar::with(['supplierById', 'barangById'])->get();

        // Pilih view PDF sesuai role
        if ($role === 'admin') {
            $view = 'admin.laporan.laporan-barang-keluar-pdf';
        } else {
            $view = 'users.laporan.laporan-barang-keluar-pdf';
        }

        $pdf = Pdf::loadView($view, [
            'data' => $Data
        ]);

        return $pdf->stream('laporan-barang-keluar-pdf.pdf');
    }
}
