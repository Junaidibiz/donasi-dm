<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonationController;
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

    // Routes untuk Laporan Donasi <-- TAMBAHKAN BLOK INI
    Route::get('/donation', [DonationController::class, 'index'])->name('donation.index');
    Route::get('/donation/filter', [DonationController::class, 'filter'])->name('donation.filter');

    // --- Route untuk Slider ---
    // Karena kita hanya butuh beberapa method, kita gunakan ->only()
    Route::resource('/slider', SliderController::class)->only([
        'index',    // GET /slider
        'create',   // GET /slider/create
        'store',    // POST /slider
        'destroy'   // DELETE /slider/{slider}
    ]);

    // Route untuk menangani upload gambar Trix 
    Route::post('/trix-upload', [TrixUploadController::class, 'store'])->name('trix.upload');
    Route::post('/trix-remove', [TrixUploadController::class, 'remove'])->name('trix.remove');
    
    // Fallback jika route tidak ditemukan
    Route::fallback(function() {
        return view('pages.utility.404');
    });    
});