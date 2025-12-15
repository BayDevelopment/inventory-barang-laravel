<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
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
});

// Dashboard user
Route::middleware(['role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});
