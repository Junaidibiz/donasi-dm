<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Menampilkan semua kategori dengan paginasi.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Ambil data kategori, 12 per halaman
        $categories = Category::latest()->paginate(12);

        return response()->json([
            'success' => true,
            'message' => 'List Data Categories',
            'data'    => $categories,
        ], 200);
    }

    /**
     * Menampilkan detail kategori beserta campaign di dalamnya.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        // Ambil kategori berdasarkan slug, beserta relasi campaign
        $category = Category::with('campaigns.user', 'campaigns.sumDonation')->where('slug', $slug)->first();

        if ($category) {
            return response()->json([
                'success' => true,
                'message' => 'List Data Campaign Berdasarkan Category: ' . $category->name,
                'data'    => $category,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Category Tidak Ditemukan!',
        ], 404);
    }

    /**
     * Menampilkan kategori untuk halaman utama.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryHome()
    {
        // Ambil 3 kategori terbaru
        $categories = Category::latest()->take(3)->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Category Home',
            'data'    => $categories,
        ], 200);
    }
}