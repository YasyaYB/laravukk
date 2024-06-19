<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\barangController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\barangmasukController;
use App\Http\Controllers\barangkeluarController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

//route resource for products
Route::resource('/products', \App\Http\Controllers\ProductController::class);
Route::resource('barang',barangController::class);
Route::resource('kategori',kategoriController::class);
Route::resource('barangmasuk',barangmasukController::class);
Route::resource('barangkeluar',barangkeluarController::class);
Route::get('login', [loginController::class,'index'])->name('login')->middleware('guest');
Route::post('login', [loginController::class,'authenticate']);
Route::post('logout', [loginController::class,'logout']);
Route::get('logout', [loginController::class,'logout']);
Route::post('register', [RegisterController::class,'store']);
Route::get('register', [RegisterController::class,'create']);
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


