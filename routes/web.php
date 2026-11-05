<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'home'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    // ===== ADMIN =====
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        Route::get('/menu', [AdminController::class, 'menuIndex'])->name('menu.index');
        Route::get('/menu/create', [AdminController::class, 'menuCreate'])->name('menu.create');
        Route::post('/menu', [AdminController::class, 'menuStore'])->name('menu.store');
        Route::get('/menu/{menu}/edit', [AdminController::class, 'menuEdit'])->name('menu.edit');
        Route::put('/menu/{menu}', [AdminController::class, 'menuUpdate'])->name('menu.update');
        Route::delete('/menu/{menu}', [AdminController::class, 'menuDestroy'])->name('menu.destroy');
        Route::get('/pesanan', [AdminController::class, 'pesananIndex'])->name('pesanan.index');
        Route::patch('/pesanan/{pesanan}', [AdminController::class, 'pesananUpdate'])->name('pesanan.update');
    });

    // ===== SISWA =====
    Route::middleware('role:siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('dashboard');
        Route::post('/menu/{menu}/pesan', [SiswaController::class, 'pesan'])->name('pesan');
        Route::get('/riwayat', [SiswaController::class, 'riwayat'])->name('riwayat');
        Route::get('/pesanan/{pesanan}/bayar', [SiswaController::class, 'bayar'])->name('bayar');
        Route::post('/pesanan/{pesanan}/bayar', [SiswaController::class, 'simpanBayar'])->name('bayar.simpan');
    });

    // ===== KASIR =====
    Route::middleware('role:kasir')->prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('dashboard');
        Route::patch('/pesanan/{pesanan}', [KasirController::class, 'updateStatus'])->name('pesanan.status');
    });
});