<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $categories = Category::latest()->when(request()->q, function($categories) {
            $categories = $categories->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('pages.category.index', compact('categories'));
    }
    
    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('pages.category.create');
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
        'name'  => 'required|unique:categories' 
    ]); 

    //upload image
    $image = $request->file('image');
    $image->storeAs('categories', $image->hashName(), 'public');

    //save to DB
    $category = Category::create([
        'image'  => $image->hashName(),
        'name'   => $request->name,
        'slug'   => Str::slug($request->name, '-')
    ]);

    if($category){
            //redirect dengan pesan sukses
            return redirect()->route('pages.category.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('pages.category.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    
    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $category
     * @return void
     */
    public function edit(Category $category)
    {
        return view('pages.category.edit', compact('category'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $category
     * @return void
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'  => 'required|unique:categories,name,'.$category->id 
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $category = Category::findOrFail($category->id);
            $category->update([
                'name'   => $request->name,
                'slug'   => Str::slug($request->name, '-')
            ]);

        } else {

            //hapus image lama
            Storage::disk('public')->delete('categories/'.basename($category->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('categories', $image->hashName(), 'public');

            //update dengan image baru
            $category = Category::findOrFail($category->id);
            $category->update([
                'image'  => $image->hashName(),
                'name'   => $request->name,
                'slug'   => Str::slug($request->name, '-')
            ]);
        }

        if($category){
            //redirect dengan pesan sukses
            return redirect()->route('pages.category.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('pages.category.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        Storage::disk('public')->delete('categories/'.basename($category->image));
        $category->delete();

        if($category){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}