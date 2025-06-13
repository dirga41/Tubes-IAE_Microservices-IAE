<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
// routes/api.php
use App\Models\Product;

Route::get('/product/{id}', [ProductController::class, 'show']);

Route::get('/product-list', fn() => response()->json(Product::all()));


// ✅ GET semua produk
Route::get('/products', [ProductController::class, 'index']);

// ✅ GET 1 produk berdasarkan ID
Route::get('/products/{id}', [ProductController::class, 'show']);

// ✅ POST produk baru
Route::post('/products', [ProductController::class, 'store']);

// ✅ PUT (update) produk berdasarkan ID
Route::put('/products/{id}', [ProductController::class, 'update']);

// ✅ DELETE produk berdasarkan ID
Route::delete('/products/{id}', [ProductController::class, 'destroy']);


Route::apiResource('products', ProductController::class);