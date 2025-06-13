<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/orders/user/{userId}', [OrderController::class, 'getOrdersByUser']);
Route::get('/orders/product/{productId}', [OrderController::class, 'getOrdersByProduct']);
Route::post('/orders', [OrderController::class, 'apiStore']);
Route::get('/orders', [OrderController::class, 'apiIndex']);

Route::post('orders', [OrderController::class, 'store']);
Route::get('orders/{order}', [OrderController::class, 'show']);