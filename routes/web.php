<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PesananController;
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
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('password.update');
    Route::post('/profil/ajukan-toko', [\App\Http\Controllers\ProfileController::class, 'ajukanToko'])->name('profile.ajukan_toko');

    // Route Keranjang Belanja
    Route::get('/cart', [KeranjangController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [KeranjangController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [KeranjangController::class, 'update'])->name('cart.update');
    Route::delete('/cart/bulk-delete', [KeranjangController::class, 'destroyMultiple'])->name('cart.destroy_multiple');
    Route::delete('/cart/{id}', [KeranjangController::class, 'destroy'])->name('cart.destroy');

    // Route Checkout & Pembayaran
    Route::post('/checkout/prepare-cart', [\App\Http\Controllers\CheckoutController::class, 'prepareCart'])->name('checkout.prepare_cart');
    Route::post('/checkout/prepare-direct', [\App\Http\Controllers\CheckoutController::class, 'prepareDirect'])->name('checkout.prepare_direct');
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/payment/{id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/payment/{id}/confirm', [\App\Http\Controllers\CheckoutController::class, 'confirmPayment'])->name('checkout.confirm');
    Route::post('/payment/{id}/cancel', [\App\Http\Controllers\CheckoutController::class, 'cancelPayment'])->name('checkout.cancel');

    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::put('/pesanan/{id}/selesai', [PesananController::class, 'selesai'])->name('pesanan.selesai');
    Route::post('/pesanan/{id}/review', [PesananController::class, 'submitReview'])->name('pesanan.review');
});

// AREA KHUSUS ADMIN
Route::middleware(['auth', IsAdmin::class])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Kelola Pesanan
    Route::get('/admin/pesanan', [\App\Http\Controllers\AdminController::class, 'pesananIndex'])->name('admin.pesanan.index');
    Route::put('/admin/pesanan/{id}/status', [\App\Http\Controllers\AdminController::class, 'updateStatus'])->name('admin.pesanan.update_status');

    // Kelola Produk
    Route::get('/admin/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/admin/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/admin/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/admin/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/admin/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/admin/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // KHUSUS SUPER ADMIN: KELOLA PENGAJUAN TOKO
    Route::get('/superadmin/pengajuan', [\App\Http\Controllers\SuperAdminController::class, 'index'])->name('superadmin.admin_list');
    Route::put('/superadmin/pengajuan/{id}/approve', [\App\Http\Controllers\SuperAdminController::class, 'approve'])->name('superadmin.approve');
    Route::put('/superadmin/pengajuan/{id}/reject', [\App\Http\Controllers\SuperAdminController::class, 'reject'])->name('superadmin.reject');
});
