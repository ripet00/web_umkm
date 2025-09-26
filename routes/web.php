<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SellerRegisterController;
use App\Http\Controllers\SellerLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// --- Rute Halaman Statis & Publik ---
Route::get('/', [PageController::class, 'welcome'])->name('welcome'); // Halaman splash screen
Route::get('/home', [HomeController::class, 'index'])->name('home'); // Halaman utama (daftar produk)

// Route::get('/products/{product}', [HomeController::class, 'show'])->name('products.show.public'); // Untuk detail produk

// --- Rute Halaman Login ---
// Halaman pemilihan peran (User atau Seller)
Route::get('login', function() { return view('auth.login'); })->middleware('guest')->name('login');
// Halaman form login untuk User
Route::get('user/login', function() { return view('auth.user-login'); })->middleware('guest:web')->name('user.login');
// Halaman form register untuk User
Route::get('user/register', function() { return view('auth.user-register'); })->middleware('guest:web')->name('user.register');

// Halaman form login untuk User
Route::get('seller/login', function() { return view('auth.seller-login'); })->middleware('guest:web')->name('seller.login');
// Halaman form register untuk User
Route::get('seller/register', function() { return view('auth.seller-register'); })->middleware('guest:web')->name('user.register');

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
    Route::get('register', [SellerRegisterController::class, 'create'])->middleware('guest:seller')->name('register');
    Route::post('register', [SellerRegisterController::class, 'store'])->middleware('guest:seller');
    
// --- Rute Khusus Seller (Dashboard & Manajemen Produk) ---
    Route::middleware('auth:seller')->group(function () {
        Route::get('/dashboard', function () { return "Welcome to Seller Dashboard"; })->name('dashboard');
        Route::post('logout', [SellerLoginController::class, 'destroy'])->name('logout');
        Route::resource('products', ProductController::class);
    });
});

require __DIR__.'/auth.php';
