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
        // PERUBAHAN 1: Validasi link diubah menjadi 'nullable' dan 'url'
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link'  => 'nullable|url' 
        ]);

        // Upload gambar
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());

        // PERUBAHAN 2: Jika link kosong, beri nilai default '#'
        $link = $request->link ?? '#';
        if (empty(trim($link))) {
            $link = '#';
        }

        // Simpan ke DB
        Slider::create([
            'image'  => $image->hashName(),
            'link'   => $link
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