<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;

class SliderController extends Controller
{
    /**
     * Menampilkan semua data slider.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Ambil semua data slider, diurutkan dari yang terbaru
        $sliders = Slider::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Sliders',
            'data'    => $sliders,
        ], 200);
    }
}