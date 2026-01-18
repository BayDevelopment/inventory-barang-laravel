<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\BarangModel;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\Models\SupplierModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        // 1️⃣ Query dasar
        $query = BarangKeluar::with([
            'barangById.kategori',
            'supplierById',
        ]);

        // 2️⃣ SEARCH
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

        // 3️⃣ FILTER KATEGORI
        if ($request->filled('kategori')) {
            $query->whereHas('barangById', function ($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        // 4️⃣ Pagination
        $DBarangKeluar = $query->paginate(5)->withQueryString();

        // 5️⃣ Tentukan role user
        $role = Auth::user()?->role ?? abort(403, 'Unauthorized');

        // 6️⃣ Data yang dikirim ke view
        $data = [
            'title' => 'Barang Keluar | Inventory Barang',
            'navlink' => 'Barang Keluar',
            'd_barangkeluar' => $DBarangKeluar,
            'kategoriList' => KategoriModel::all(),
            'role' => $role,
        ];

        // 7️⃣ Pilih view sesuai role
        if ($role === 'admin') {
            return view('admin.barang-keluar.page-barang-keluar', $data);
        } elseif ($role === 'user') {
            return view('users.barang-keluar.page-barang-keluar', $data);
        }

        // 8️⃣ Jika role lain, blokir
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }


    public function PageTambahBKeluar()
    {
        $role = Auth::user()->role; // Ambil role user (admin / users)

        // Ambil semua data supplier dan barang
        $DataSupplier = SupplierModel::all();
        $DataBarang = BarangModel::all();

        $data = [
            'title' => 'Tambah Barang Keluar | Inventory Barang',
            'navlink' => 'Tambah Barang Keluar',
            'DSupplier' => $DataSupplier,
            'DBarang' => $DataBarang,
            'role' => $role, // Kirim role ke view untuk URL dan route dinamis
        ];

        // Tentukan view sesuai role
        if ($role === 'admin') {
            return view('admin.barang-keluar.page-tambah-barang-keluar', $data);
        } elseif ($role === 'user') {
            return view('users.barang-keluar.page-tambah-barang-keluar', $data);
        }

        // Jika role lain, blokir akses
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }


    public function AksiTambahBKeluar(Request $request)
    {
        $role = Auth::user()->role; // Ambil role (admin / user)

        // ✅ Validasi input
        $validated = $request->validate(
            [
                'id_barang' => 'required|exists:tb_barang,id_barang',
                'id_supplier' => 'required|exists:tb_supplier,id_supplier',
                'tanggal_keluar' => 'required|date',
                'jumlah_keluar' => 'required|integer|min:1',
                'harga_beli' => 'required|numeric|min:1',
                'keterangan' => 'nullable|string',
            ],
            [
                'id_barang.required' => 'Barang wajib dipilih.',
                'id_barang.exists' => 'Barang yang dipilih tidak valid.',
                'id_supplier.required' => 'Supplier wajib dipilih.',
                'id_supplier.exists' => 'Supplier yang dipilih tidak valid.',
                'tanggal_keluar.required' => 'Tanggal keluar wajib diisi.',
                'tanggal_keluar.date' => 'Format tanggal keluar tidak valid.',
                'jumlah_keluar.required' => 'Jumlah keluar wajib diisi.',
                'jumlah_keluar.integer' => 'Jumlah keluar harus berupa angka bulat.',
                'jumlah_keluar.min' => 'Jumlah keluar minimal 1.',
                'harga_beli.required' => 'Harga beli wajib diisi.',
                'harga_beli.numeric' => 'Harga beli harus berupa angka.',
                'harga_beli.min' => 'Harga beli minimal Rp 1.',
            ]
        );

        // Paksa timezone Asia/Jakarta
        $validated['tanggal_keluar'] = Carbon::parse(
            $validated['tanggal_keluar'],
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');

        DB::transaction(function () use ($validated) {

            // 1️⃣ Simpan transaksi barang keluar
            BarangKeluar::create($validated);

            // 2️⃣ Update stok barang (kurangi)
            $barang = BarangModel::lockForUpdate()->findOrFail($validated['id_barang']);
            $barang->stok -= $validated['jumlah_keluar'];
            $barang->save();
        });

        // 🔄 Redirect sesuai role menggunakan if
        if ($role === 'admin') {
            return redirect()
                ->route('admin.barang-keluar-data')
                ->with('success', 'Barang keluar berhasil ditambahkan & stok diperbarui.');
        } elseif ($role === 'user') {
            return redirect()
                ->route('user.barang-keluar-data') // folder user kamu: users
                ->with('success', 'Barang keluar berhasil ditambahkan & stok diperbarui.');
        } else {
            abort(403, 'Anda tidak memiliki akses.');
        }
    }


    public function PageEditBKeluar($id)
    {
        $DataSupplier = SupplierModel::all();
        $DataBarang = BarangModel::all();
        $DBarangMasuk = BarangKeluar::findOrFail($id);

        $data = [
            'title' => 'Page Edit Barang Keluar | Inventory Barang',
            'navlink' => 'Page Edit Barang Keluar',
            'DSupplier' => $DataSupplier,
            'DBarang' => $DataBarang,
            'BK' => $DBarangMasuk, // biar gampang di blade
        ];
        return view('admin.barang-keluar.page-edit-barang-keluar', $data);
    }

    public function AksiEditBKeluar(Request $request, $id)
    {
        $validated = $request->validate(
            [
                'id_barang' => 'required|exists:tb_barang,id_barang',
                'id_supplier' => 'required|exists:tb_supplier,id_supplier',
                'tanggal_keluar' => 'required|date',
                'jumlah_keluar' => 'required|integer|min:1',
                'harga_beli' => 'required|numeric|min:1',
                'keterangan' => 'nullable|string',
            ],
            [
                'id_barang.required' => 'Barang wajib dipilih.',
                'id_barang.exists' => 'Barang yang dipilih tidak valid.',
                'id_supplier.required' => 'Supplier wajib dipilih.',
                'id_supplier.exists' => 'Supplier yang dipilih tidak valid.',
                'tanggal_keluar.required' => 'Tanggal masuk wajib diisi.',
                'tanggal_keluar.date' => 'Format tanggal masuk tidak valid.',
                'jumlah_keluar.required' => 'Jumlah masuk wajib diisi.',
                'jumlah_keluar.integer' => 'Jumlah masuk harus berupa angka bulat.',
                'jumlah_keluar.min' => 'Jumlah masuk minimal 1.',
                'harga_beli.required' => 'Harga beli wajib diisi.',
                'harga_beli.numeric' => 'Harga beli harus berupa angka.',
                'harga_beli.min' => 'Harga beli minimal Rp 1.',
            ]
        );
        // ✅ Paksa timezone Asia/Jakarta (WIB)
        $validated['tanggal_keluar'] = Carbon::parse(
            $validated['tanggal_keluar'],
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');

        DB::transaction(function () use ($validated, $id) {

            // Ambil transaksi lama
            $bm = BarangKeluar::lockForUpdate()->findOrFail($id);

            $oldBarangId = $bm->id_barang;
            $oldQty = (int) $bm->jumlah_keluar;

            $newBarangId = (int) $validated['id_barang'];
            $newQty = (int) $validated['jumlah_keluar'];

            // 1) Balikkan stok dari transaksi lama (kurangi stok barang lama)
            $oldBarang = BarangModel::lockForUpdate()->findOrFail($oldBarangId);
            $oldBarang->stok -= $oldQty;
            $oldBarang->save();

            // 2) Update transaksi barang masuk
            $bm->update($validated);

            // 3) Terapkan stok baru (tambah stok barang baru)
            $newBarang = BarangModel::lockForUpdate()->findOrFail($newBarangId);
            $newBarang->stok += $newQty;
            $newBarang->save();
        });

        return redirect()
            ->route('admin.barang-keluar-data')
            ->with('success', 'Barang keluar berhasil diupdate & stok diperbarui.');
    }

    public function BarangKeluarDestroy($id)
    {
        DB::transaction(function () use ($id) {
            $bm = BarangKeluar::findOrFail($id);

            // ambil barang terkait
            $barang = BarangModel::findOrFail($bm->id_barang);

            // kurangi stok sesuai jumlah masuk yang dihapus
            $barang->stok = max(0, $barang->stok - $bm->jumlah_keluar);
            $barang->save();

            // hapus transaksi barang masuk
            $bm->delete();
        });

        return redirect()
            ->route('admin.barang-keluar-data')
            ->with('success', 'Data Barang Keluar berhasil dihapus & stok dikurangi.');
    }
}
