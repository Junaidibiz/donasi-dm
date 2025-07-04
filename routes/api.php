<?php

use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- API PUBLIK (Tidak perlu login) ---

// Route untuk Registrasi dan Login Donatur
Route::post('/register', RegisterController::class);
Route::post('/login', [LoginController::class, 'login']);

// Route untuk Category
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);
Route::get('/categoryHome', [CategoryController::class, 'categoryHome']);

// Route untuk Campaign
Route::get('/campaign', [CampaignController::class, 'index']);
Route::get('/campaign/{slug}', [CampaignController::class, 'show']);

// Route untuk Slider
Route::get('/slider', [SliderController::class, 'index']);

// Route untuk notifikasi Midtrans
Route::post('/donation/notification', [DonationController::class, 'notificationHandler']);


// --- API TERPROTEKSI (Perlu login) ---
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [LoginController::class, 'logout']);

    // Route untuk Profile
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'updatePassword']);
    
    // --- TAMBAHKAN ROUTE BARU INI ---
    Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar']);
    // ---------------------------------

    // Route untuk Donasi (membuat & melihat riwayat)
    Route::post('/donation', [DonationController::class, 'store']);
    Route::get('/donation', [DonationController::class, 'index']);

});