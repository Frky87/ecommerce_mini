<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KeranjangController;
use App\Http\Middleware\IsAdmin;

// ROUTE DEFAULT
Route::get('/', function () {
    return redirect()->route('katalog');
});

// KATALOG (Publik & User Biasa)
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');

// AREA GUEST (Hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister']);

    // Login Google
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

// AREA USER & ADMIN (Harus Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route Edit Profil
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    // Route Keranjang Belanja
    Route::get('/cart', [KeranjangController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [KeranjangController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [KeranjangController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [KeranjangController::class, 'destroy'])->name('cart.destroy');
});

// AREA KHUSUS ADMIN
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/admin/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/admin/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/admin/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/admin/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/admin/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});
