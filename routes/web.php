<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbsensiController;

// Default redirect
Route::get('/', fn () => redirect()->route('login'));

// Auth
Route::get('/login', fn () => view('login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Test middleware
Route::get('/test-middleware', fn () => 'Middleware is reachable')->middleware('checkRole:admin');

    // Authenticated routes
    Route::middleware(['auth'])->group(function () {

        // Admin-only routes dengan prefix dan nama route grup
        Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // User management
        Route::get('/users', [AdminController::class, 'listUsers'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users/store', [AdminController::class, 'storeUser'])->name('users.store');

        // Jadwal absensi
        Route::get('/jadwal/form', [AdminController::class, 'formJadwal'])->name('jadwal.form');
        Route::post('/jadwal/store', [AdminController::class, 'storeJadwal'])->name('jadwal.store');

        // Riwayat absensi
        Route::get('/riwayat', [AdminController::class, 'riwayatAbsensi'])->name('riwayat');
    });


    // Absensi (akses umum setelah login)
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/submit-status', [AbsensiController::class, 'submit'])->name('absensi.submit-status');
});

