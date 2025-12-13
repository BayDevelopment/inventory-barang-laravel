<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/auth/login');
});

Route::get('/auth/login', [AuthController::class, 'PageLogin'])->name('page.login');
Route::post('/auth/login', [AuthController::class, 'AksiLogin'])->name('aksi.login');
Route::get('/auth/forgot-password', [AuthController::class, 'ForgotPassword'])->name('forgot.password');

// ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
});

// USER
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');
});
