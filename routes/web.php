<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SellerRegisterController;
use App\Http\Controllers\SellerLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;


// --- Rute Halaman Statis & Publik ---
Route::get('/', [PageController::class, 'welcome'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/products/{product}', [HomeController::class, 'show'])->name('products.show');

// --- Rute Webhook Midtrans ---
Route::post('/midtrans/callback', [OrderController::class, 'callback'])->name('midtrans.callback');


// --- Rute Halaman Login ---
Route::get('login', function() { return view('auth.login'); })->middleware('guest')->name('login');
Route::get('user/login', function() { return view('auth.user-login'); })->middleware('guest:web')->name('user.login');
Route::get('user/register', function() { return view('auth.user-register'); })->middleware('guest:web')->name('user.register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:web', 'verified'])->name('dashboard');

Route::middleware('auth:web')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Rute Keranjang Belanja ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/item/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/item/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // --- Rute Pesanan & Checkout ---
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders/process', [OrderController::class, 'process'])->name('orders.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// --- Rute Otentikasi & Dashboard Seller ---
Route::prefix('seller')->name('seller.')->group(function () {
    // Rute untuk Guest (Login & Register)
    Route::middleware('guest:seller')->group(function () {
        Route::get('login', [SellerLoginController::class, 'create'])->name('login');
        Route::post('login', [SellerLoginController::class, 'store']);
        Route::get('register', [SellerRegisterController::class, 'create'])->name('register');
        Route::post('register', [SellerRegisterController::class, 'store']);
    });
    
    // Rute untuk Seller yang Terotentikasi
    Route::middleware('auth:seller')->group(function () {
        Route::get('/dashboard', function () { return view('sellers.dashboard'); })->name('dashboard');
        Route::post('logout', [SellerLoginController::class, 'destroy'])->name('logout');
        
        Route::resource('products', ProductController::class);

        Route::get('/profile', [SellerProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [SellerProfileController::class, 'update'])->name('profile.update');
        
        // --- Rute Pesanan Seller ---
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    });
});

require __DIR__.'/auth.php';

