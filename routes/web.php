<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminAbsensiController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');

    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminAbsensiController::class, 'index'])->name('admin.index');
        Route::post('/admin/buat-akun', [AdminAbsensiController::class, 'buat'])->name('admin.buat');
    });
});

