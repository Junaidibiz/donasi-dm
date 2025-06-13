<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrixUploadController extends Controller
{
    /**
     * Menyimpan attachment yang di-upload oleh Trix Editor.
     */
    public function store(Request $request)
    {
        // Validasi bahwa file ada dan merupakan gambar
        $request->validate([
            'attachment' => 'required|image|max:2048',
        ]);

        // Simpan file ke storage publik
        $path = $request->file('attachment')->store('public/attachments');

        // Kembalikan URL publik dari file tersebut
        return response()->json(['url' => Storage::url($path)]);
    }

    /**
     * Menghapus attachment dari storage.
     */
    public function remove(Request $request)
    {
        // Hapus file dari storage berdasarkan URL yang diberikan
        Storage::disk('public')->delete(str_replace('/storage/', '', $request->input('url')));

        return response()->noContent();
    }
}