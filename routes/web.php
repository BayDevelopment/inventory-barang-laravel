<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanBarangKeluar;
use App\Http\Controllers\LaporanBarangMasuk;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/auth/login');
});

// Login page
Route::get('/auth/login', [AuthController::class, 'PageLogin'])
    ->name('page.login')
    ->middleware('role'); // middleware gabungan

Route::post('/auth/login', [AuthController::class, 'AksiLogin'])
    ->name('aksi.login');

// Logout
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard admin
Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // barang
    Route::get('/data-barang', [BarangController::class, 'PageBarang'])->name('admin.data-barang');
    Route::get('/data-barang/tambah', [BarangController::class, 'PageTambahBarang'])->name('admin.data-barang-tambah');
    Route::post('/data-barang/tambah', [BarangController::class, 'AksiTambahBarang'])->name('admin.data-barang-aksi');
    Route::get('/data-barang/{id}/edit', [BarangController::class, 'PageEditBarang'])->name('admin.data-barang-edit-page');
    Route::put('/data-barang/{id}/edit', [BarangController::class, 'AksiBarangEdit'])->name('admin.data-barang-edit-aksi');
    Route::delete('/barang-hapus/{id}', [BarangController::class, 'BarangDestroy'])->name('admin.data-barang-edit-aksi-delete');

    // kategori
    Route::get('/kategori', [KategoriController::class, 'PageKategori'])->name('admin.kategori');
    Route::get('/kategori-tambah', [KategoriController::class, 'PageInsert'])->name('admin.kategori-tambah');
    Route::post('/kategori-tambah', [KategoriController::class, 'KategoriAksi'])->name('admin.kategori-aksi');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'PageEdit'])
        ->name('admin.kategori-edit');
    Route::put('kategori/{id}', [KategoriController::class, 'KategoriAksiUpdate'])
        ->name('admin.kategori-update');
    Route::delete('/kategori-hapus/{id}', [KategoriController::class, 'KategoriDestroy'])->name('admin.kategori-aksi-hapus');

    // suupplier
    Route::get('data-supplier', [SupplierController::class, 'index'])
        ->name('admin.supplier-data');
    Route::get('data-supplier/tambah', [SupplierController::class, 'PageTambah'])
        ->name('admin.supplier-tambah-page');
    Route::post('data-supplier/tambah', [SupplierController::class, 'AksiTambah'])
        ->name('admin.supplier-tambah-aksi');
    Route::get('data-supplier/{id}/edit', [SupplierController::class, 'PageEdit'])
        ->name('admin.data-supplier-edit-page');
    Route::put('data-supplier/{id}', [SupplierController::class, 'AksiEdit'])
        ->name('admin.supplier-edit-aksi');
    Route::delete('/supplier-hapus/{id}', [SupplierController::class, 'SupplierDestroy'])->name('admin.supplier-aksi-hapus');

    // barang masuk
    Route::get('data-barang-masuk', [BarangMasukController::class, 'index'])
        ->name('admin.barang-masuk-data');
    Route::get('data-barang-masuk/tambah', [BarangMasukController::class, 'PageTambahBMasuk'])
        ->name('admin.barang-masuk-page-tambah');
    Route::post('data-barang-masuk/tambah', [BarangMasukController::class, 'AksiTambahBMasuk'])
        ->name('admin.barang-masuk-aksi-tambah');
    Route::get('data-barang-masuk/{id}/edit', [BarangMasukController::class, 'PageEditBMasuk'])
        ->name('admin.data-barang-masuk-edit-page');
    Route::put('data-barang-masuk/{id}/edit', [BarangMasukController::class, 'AksiEditBmasuk'])
        ->name('admin.barang-masuk-aksi-edit');
    Route::delete('/data-barang-masuk-hapus/{id}', [BarangMasukController::class, 'BarangMasukDestroy'])->name('admin.barang-masuk-aksi-hapus');

    // barang keluar
    Route::get('data-barang-keluar', [BarangKeluarController::class, 'index'])
        ->name('admin.barang-keluar-data');
    Route::get('data-barang-keluar/tambah', [BarangKeluarController::class, 'PageTambahBKeluar'])
        ->name('admin.barang-keluar-page-tambah');
    Route::post('data-barang-keluar/tambah', [BarangKeluarController::class, 'AksiTambahBKeluar'])
        ->name('admin.barang-keluar-aksi-tambah');
    Route::get('data-barang-keluar/{id}/edit', [BarangKeluarController::class, 'PageEditBKeluar'])
        ->name('admin.data-barang-keluar-edit-page');
    Route::put('data-barang-keluar/{id}/edit', [BarangKeluarController::class, 'AksiEditBKeluar'])
        ->name('admin.barang-keluar-aksi-edit');
    Route::delete('/data-barang-keluar-hapus/{id}', [BarangKeluarController::class, 'BarangKeluarDestroy'])->name('admin.barang-keluar-aksi-hapus');

    // laporan
    Route::get('laporan/barang-masuk', [LaporanBarangMasuk::class, 'index'])
        ->name('admin.laporan.masuk');
    Route::get('laporan/barang-keluar', [LaporanBarangKeluar::class, 'index'])
        ->name('admin.laporan.keluar');
    // laporan barang masuk pdf
    Route::get('laporan/barang-masuk/pdf', [LaporanBarangMasuk::class, 'printPDF'])
        ->name('admin.laporan.masuk-pdf');
    // laporan barang keluar pdf
    Route::get('laporan/barang-keluar/pdf', [LaporanBarangKeluar::class, 'printPDF'])
        ->name('admin.laporan.keluar-pdf');


    // Pengaturan 
    Route::get('setting', [AdminDashboardController::class, 'settings'])
        ->name('admin.setting');
    Route::post('setting/profile', [AdminDashboardController::class, 'settingsProfileAksi'])
        ->name('admin.setting-profile');
    Route::post('setting/security', [AdminDashboardController::class, 'settingsPasswordAksi'])
        ->name('admin.setting-security');
});

// Dashboard user
Route::middleware(['role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});
