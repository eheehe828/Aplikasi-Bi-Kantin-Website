<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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
    });

    // ===== SISWA =====
    Route::middleware('role:siswa')->group(function () {
        Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.dashboard');
    });
});