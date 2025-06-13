<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donatur;

class DonaturController extends Controller
{    
    /**
     * Menampilkan halaman daftar donatur.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $donaturs = Donatur::latest()->when(request()->q, function($donaturs) {
            $donaturs = $donaturs->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        // Mengarahkan ke view yang akan kita buat nanti
        return view('pages.donatur.index', compact('donaturs'));
    }
}