<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::latest()->when(request()->q, function($categories) {
            $categories = $categories->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        // Menggunakan path view dari proyek kita
        return view('pages.category.index', compact('categories'));
    }
    
    /**
     * Menampilkan form untuk membuat kategori baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Menggunakan path view dari proyek kita
        return view('pages.category.create');
    }
    
    /**
     * Menyimpan kategori baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'name'  => 'required|unique:categories' 
        ]); 

        // Upload gambar
        $image = $request->file('image');
        $image->storeAs('categories', $image->hashName(), 'public');

        // Simpan ke DB
        $category = Category::create([
            'image'  => $image->hashName(),
            'name'   => $request->name,
            'slug'   => Str::slug($request->name, '-')
        ]);

        if($category){
            // Menggunakan nama route dari proyek kita
            return redirect()->route('category.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            return redirect()->route('category.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    
    /**
     * Menampilkan form untuk mengedit kategori.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        // Menggunakan path view dari proyek kita
        return view('pages.category.edit', compact('category'));
    }
    
    /**
     * Memperbarui data kategori di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'  => 'required|unique:categories,name,'.$category->id 
        ]); 

        // Siapkan data untuk diupdate
        $updateData = [
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ];

        // Cek jika ada file gambar baru yang di-upload
        if ($request->hasFile('image')) {
            $request->validate(['image' => 'image|mimes:jpeg,jpg,png|max:2000']);

            // **FIX**: Hapus gambar lama dengan cara yang aman
            $oldImage = $category->getRawOriginal('image');
            if ($oldImage && Storage::disk('public')->exists('categories/' . $oldImage)) {
                Storage::disk('public')->delete('categories/' . $oldImage);
            }

            // Upload gambar baru
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->storeAs('categories', $imageName, 'public');

            $updateData['image'] = $imageName;
        }

        if ($category->update($updateData)) {
            // Menggunakan nama route dari proyek kita
            return redirect()->route('category.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            return redirect()->route('category.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
    /**
     * Menghapus kategori dari database.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        // **FIX**: Ambil nama file asli sebelum dihapus
        $imageNameToDelete = $category->getRawOriginal('image');

        if ($category->delete()) {
            // Hapus file gambar HANYA JIKA record database berhasil dihapus
            if ($imageNameToDelete && Storage::disk('public')->exists('categories/' . $imageNameToDelete)) {
                Storage::disk('public')->delete('categories/' . $imageNameToDelete);
            }
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}