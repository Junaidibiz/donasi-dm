<?php

use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

/**
 * Route untuk Registrasi Donatur
 */
Route::post('/register', RegisterController::class);

/**
 * Route untuk Login Donatur
 */
Route::post('/login', [LoginController::class, 'login']);

/**
 * Route di dalam grup ini memerlukan otentikasi
 */
Route::middleware('auth:sanctum')->group(function () {
    
    // Route untuk mendapatkan data user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route untuk Logout Donatur
    Route::post('/logout', [LoginController::class, 'logout']);

});