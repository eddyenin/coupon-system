<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/',[ProductController::class,'index']);
Route::get('/cart',[CartController::class,'index']);
Route::get('/show',[CartController::class,'show']);
Route::post('/check',[CouponController::class,'checkCoupon']);

