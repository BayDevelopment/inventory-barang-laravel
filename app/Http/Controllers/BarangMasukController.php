<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\SupplierModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangMasuk::with([
            'barangById.kategori',
            'supplierById',
        ]);

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

        if ($request->filled('kategori')) {
            $query->whereHas('barangById', function ($q) use ($request) {
                $q->where('id_kategori', $request->kategori);
            });
        }

        $DBarangMasuk = $query->paginate(5)->withQueryString();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $role = $user->role;

        $data = [
            'title' => 'Barang Masuk | Inventory Barang',
            'navlink' => 'Barang Masuk',
            'd_barangmasuk' => $DBarangMasuk,
            'kategoriList' => KategoriModel::all(),
            'role' => $role,
        ];

        if ($role === 'admin') {
            return view('admin.barang-masuk.page-barang-masuk', $data);
        } elseif ($role === 'user') {
            return view('users.barang-masuk.data-barang-masuk', $data);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }


    public function PageTambahBMasuk()
    {
        // Ambil data supplier dan barang
        $DataSupplier = SupplierModel::all();
        $DataBarang = BarangModel::all();

        // Tentukan role user
        $user = Auth::user();
        $role = $user->role ?? abort(403, 'Unauthorized');

        // Data yang dikirim ke view
        $data = [
            'title' => 'Tambah Barang Masuk | Inventory Barang',
            'navlink' => 'Tambah Barang Masuk',
            'DSupplier' => $DataSupplier,
            'DBarang' => $DataBarang,
            'role' => $role,
        ];

        // Pilih view sesuai role
        if ($role === 'admin') {
            return view('admin.barang-masuk.page-tambah-barang-masuk', $data);
        } elseif ($role === 'user') {
            return view('users.barang-masuk.page-tambah-barang-masuk', $data);
        }

        // Jika role lain, blokir akses
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }


    public function AksiTambahBMasuk(Request $request)
    {
        $validated = $request->validate(
            [
                'id_barang' => 'required|exists:tb_barang,id_barang',
                'id_supplier' => 'required|exists:tb_supplier,id_supplier',
                'tanggal_masuk' => 'required|date',
                'jumlah_masuk' => 'required|integer|min:1',
                'harga_beli' => 'required|numeric|min:1',
                'keterangan' => 'nullable|string',
            ],
            [
                'id_barang.required' => 'Barang wajib dipilih.',
                'id_barang.exists' => 'Barang yang dipilih tidak valid.',
                'id_supplier.required' => 'Supplier wajib dipilih.',
                'id_supplier.exists' => 'Supplier yang dipilih tidak valid.',
                'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
                'tanggal_masuk.date' => 'Format tanggal masuk tidak valid.',
                'jumlah_masuk.required' => 'Jumlah masuk wajib diisi.',
                'jumlah_masuk.integer' => 'Jumlah masuk harus berupa angka bulat.',
                'jumlah_masuk.min' => 'Jumlah masuk minimal 1.',
                'harga_beli.required' => 'Harga beli wajib diisi.',
                'harga_beli.numeric' => 'Harga beli harus berupa angka.',
                'harga_beli.min' => 'Harga beli minimal Rp 1.',
            ]
        );

        // Paksa timezone Asia/Jakarta
        $validated['tanggal_masuk'] = Carbon::parse(
            $validated['tanggal_masuk'],
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');

        DB::transaction(function () use ($validated) {
            // Simpan transaksi barang masuk
            BarangMasuk::create($validated);

            // Update stok barang
            $barang = BarangModel::lockForUpdate()
                ->findOrFail($validated['id_barang']);
            $barang->stok += $validated['jumlah_masuk'];
            $barang->save();
        });

        // 🔹 Redirect sesuai role
        $role = Auth::user()->role;
        if ($role === 'admin') {
            return redirect()
                ->route('admin.barang-masuk-data')
                ->with('success', 'Barang masuk berhasil ditambahkan & stok diperbarui.');
        } elseif ($role === 'user') {
            return redirect()
                ->route('users.barang-masuk-data') // foldermu "users"
                ->with('success', 'Barang masuk berhasil ditambahkan & stok diperbarui.');
        }

        // Jika role lain (tidak diharapkan)
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }


    public function PageEditBMasuk($id)
    {
        $DataSupplier = SupplierModel::all();
        $DataBarang = BarangModel::all();
        $DBarangMasuk = BarangMasuk::findOrFail($id);

        return view('admin.barang-masuk.page-edit-barang-masuk', [
            'title' => 'Edit Barang Masuk | Inventory Barang',
            'navlink' => 'Edit Barang Masuk',
            'DSupplier' => $DataSupplier,
            'DBarang' => $DataBarang,
            'BM' => $DBarangMasuk, // biar gampang di blade
        ]);
    }

    public function AksiEditBmasuk(Request $request, $id)
    {
        $validated = $request->validate(
            [
                'id_barang' => 'required|exists:tb_barang,id_barang',
                'id_supplier' => 'required|exists:tb_supplier,id_supplier',
                'tanggal_masuk' => 'required|date',
                'jumlah_masuk' => 'required|integer|min:1',
                'harga_beli' => 'required|numeric|min:1',
                'keterangan' => 'nullable|string',
            ],
            [
                'id_barang.required' => 'Barang wajib dipilih.',
                'id_barang.exists' => 'Barang yang dipilih tidak valid.',
                'id_supplier.required' => 'Supplier wajib dipilih.',
                'id_supplier.exists' => 'Supplier yang dipilih tidak valid.',
                'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
                'tanggal_masuk.date' => 'Format tanggal masuk tidak valid.',
                'jumlah_masuk.required' => 'Jumlah masuk wajib diisi.',
                'jumlah_masuk.integer' => 'Jumlah masuk harus berupa angka bulat.',
                'jumlah_masuk.min' => 'Jumlah masuk minimal 1.',
                'harga_beli.required' => 'Harga beli wajib diisi.',
                'harga_beli.numeric' => 'Harga beli harus berupa angka.',
                'harga_beli.min' => 'Harga beli minimal Rp 1.',
            ]
        );
        // ✅ Paksa timezone Asia/Jakarta (WIB)
        $validated['tanggal_masuk'] = Carbon::parse(
            $validated['tanggal_masuk'],
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');

        DB::transaction(function () use ($validated, $id) {

            // Ambil transaksi lama
            $bm = BarangMasuk::lockForUpdate()->findOrFail($id);

            $oldBarangId = $bm->id_barang;
            $oldQty = (int) $bm->jumlah_masuk;

            $newBarangId = (int) $validated['id_barang'];
            $newQty = (int) $validated['jumlah_masuk'];

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
            ->route('admin.barang-masuk-data')
            ->with('success', 'Barang masuk berhasil diupdate & stok diperbarui.');
    }

    public function BarangMasukDestroy($id)
    {
        DB::transaction(function () use ($id) {
            $bm = BarangMasuk::findOrFail($id);

            // ambil barang terkait
            $barang = BarangModel::findOrFail($bm->id_barang);

            // kurangi stok sesuai jumlah masuk yang dihapus
            $barang->stok = max(0, $barang->stok - $bm->jumlah_masuk);
            $barang->save();

            // hapus transaksi barang masuk
            $bm->delete();
        });

        return redirect()
            ->route('admin.barang-masuk-data')
            ->with('success', 'Data Barang Masuk berhasil dihapus & stok dikurangi.');
    }
}
