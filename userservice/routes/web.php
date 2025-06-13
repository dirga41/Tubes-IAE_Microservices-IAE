<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderHistoryController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'registerSubmit']);

Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'loginSubmit']);

Route::get('/dashboard', [AuthController::class, 'dashboard']);
Route::get('/orders/history/{userId}', [OrderHistoryController::class, 'indexView']);

