<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrixUploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Arahkan halaman utama ke login
Route::redirect('/', 'login');

// Grup untuk semua route yang memerlukan login
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    
    // Route untuk Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Resource untuk Category
    Route::resource('category', CategoryController::class);
    
    // Route Resource untuk Campaign
    Route::resource('campaign', CampaignController::class);

    // Route untuk Donatur 
    Route::get('/donatur', [DonaturController::class, 'index'])->name('donatur.index');

    // Route untuk menangani upload gambar Trix <-- TAMBAHKAN BLOK INI
    Route::post('/trix-upload', [TrixUploadController::class, 'store'])->name('trix.upload');
    Route::post('/trix-remove', [TrixUploadController::class, 'remove'])->name('trix.remove');
    
    // Fallback jika route tidak ditemukan
    Route::fallback(function() {
        return view('pages.utility.404');
    });    
});