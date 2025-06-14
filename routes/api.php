<?php

use App\Http\Controllers\Api\RegisterController; // <-- Impor controller kita
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});