<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
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

    // suupplier
    Route::get('data-supplier', [SupplierController::class, 'index'])
        ->name('admin.supplier-data');
    Route::get('data-supplier/tambah', [SupplierController::class, 'PageTambah'])
        ->name('admin.supplier-tambah-page');
    Route::post('data-supplier/tambah', [SupplierController::class, 'AksiTambah'])
        ->name('admin.supplier-tambah-aksi');
    Route::get('data-supplier/{id}/edit', [SupplierController::class, 'PageEdit'])
        ->name('admin.data-supplier-edit-page');

    Route::delete('/kategori-hapus/{id}', [KategoriController::class, 'KategoriDestroy'])->name('admin.kategori-aksi-hapus');
});

// Dashboard user
Route::middleware(['role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});
