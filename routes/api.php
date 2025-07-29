<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- API PUBLIK (Tidak perlu login) ---

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

Route::post('/register', RegisterController::class);
Route::post('/login', [LoginController::class, 'login']);

Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);
Route::get('/categoryHome', [CategoryController::class, 'categoryHome']);

// --- PERBAIKAN URUTAN ROUTE CAMPAIGN ---
Route::get('/campaign/search', [CampaignController::class, 'search']); // <-- PINDAHKAN KE ATAS
Route::get('/campaign', [CampaignController::class, 'index']);
Route::get('/campaign/{slug}', [CampaignController::class, 'show']);
// -----------------------------------------

Route::get('/slider', [SliderController::class, 'index']);
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
    Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar']);
    
    // Route untuk Donasi (membuat & melihat riwayat)
    Route::post('/donation', [DonationController::class, 'store']);
    Route::get('/donation', [DonationController::class, 'index']);

});