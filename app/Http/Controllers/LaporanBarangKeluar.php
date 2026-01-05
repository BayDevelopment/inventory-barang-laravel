<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\KategoriModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanBarangKeluar extends Controller
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

        // 📅 FILTER TANGGAL MASUK
        if ($request->filled('tanggal_keluar')) {
            $query->where('tanggal_keluar', $request->tanggal_keluar);
        }

        // urutkan terbaru
        $query->orderBy('tanggal_keluar', 'desc');

        $DBarangKeluar = $query->paginate(5)->withQueryString();

        return view('admin.laporan.laporan-barang-keluar', [
            'title' => 'Laporan Barang Keluar | Inventory Barang',
            'navlink' => 'laporan_keluar',
            'breadcrumb' => 'Laporan Barang Keluar',
            'd_barangkeluar' => $DBarangKeluar,
            'kategoriList' => KategoriModel::all(),
        ]);
    }

    public function printPDF(){
        $Data = BarangKeluar::with(['supplierById','barangById'])->get();

        $pdf =Pdf::loadView('admin.laporan.laporan-barang-keluar-pdf',[
            'data' => $Data
        ]);

        return $pdf->stream('laporan-barang-keluar-pdf.pdf');
    }

}
