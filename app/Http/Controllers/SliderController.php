<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Menampilkan halaman daftar slider.
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(5);
        return view('pages.slider.index', compact('sliders'));
    }

    /**
     * Menampilkan form untuk membuat slider baru.
     */
    public function create()
    {
        return view('pages.slider.create');
    }

    /**
     * Menyimpan data slider baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link'  => 'required|url'
        ]);

        // Upload gambar
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());

        // Simpan ke DB
        Slider::create([
            'image'  => $image->hashName(),
            'link'   => $request->link
        ]);

        return redirect()->route('slider.index')->with(['success' => 'Data Slider Berhasil Disimpan!']);
    }

    /**
     * Menghapus data slider dari database.
     */
    public function destroy(Slider $slider)
    {
        // Ambil nama file gambar asli untuk dihapus
        $imageNameToDelete = $slider->getRawOriginal('image');
        
        if ($slider->delete()) {
            // Hapus file gambar dari storage
            if ($imageNameToDelete) {
                Storage::disk('public')->delete('sliders/' . $imageNameToDelete);
            }
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}