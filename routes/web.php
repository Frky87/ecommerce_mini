<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KatalogController;

// Halaman Pembeli (Katalog)
Route::get('/', [KatalogController::class, 'index'])->name('katalog');

// Otentikasi (Login & Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Halaman Admin (CRUD Produk - Hanya bisa diakses jika sudah login)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::resource('produk', ProdukController::class);
});
