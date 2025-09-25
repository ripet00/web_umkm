<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController; // Tambahkan ini
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\SellerLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// --- Rute Halaman Statis & Publik ---
Route::get('/', [PageController::class, 'welcome'])->name('welcome'); // Halaman splash screen
Route::get('/home', [HomeController::class, 'index'])->name('home'); // Halaman utama (daftar produk)

// Route::get('/products/{product}', [HomeController::class, 'show'])->name('products.show.public'); // Untuk detail produk

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:web', 'verified'])->name('dashboard'); // Spesifik untuk guard 'web'

Route::middleware('auth:web')->group(function () { // Spesifik untuk guard 'web'
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Rute Otentikasi Seller ---
Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('login', [SellerLoginController::class, 'create'])->middleware('guest:seller')->name('login');
    Route::post('login', [SellerLoginController::class, 'store'])->middleware('guest:seller');
    Route::post('logout', [SellerLoginController::class, 'destroy'])->middleware('auth:seller')->name('logout');
});

// --- Rute Khusus Seller (Dashboard & Manajemen Produk) ---
Route::prefix('seller')->name('seller.')->middleware('auth:seller')->group(function () {
    Route::get('/dashboard', function () {
        return "Welcome to Seller Dashboard"; // Ganti dengan view dashboard seller Anda
    })->name('dashboard');
    Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';
