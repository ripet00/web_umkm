<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('sellers', SellerController::class);
Route::resource('buyers', BuyerController::class);