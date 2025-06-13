<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Menampilkan halaman daftar campaign.
     */
    public function index()
    {
        $campaigns = Campaign::with('category')->latest()->when(request()->q, function ($query) {
            $query->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('pages.campaign.index', compact('campaigns'));
    }

    /**
     * Menampilkan form untuk membuat campaign baru.
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('pages.campaign.create', compact('categories'));
    }

    /**
     * Menyimpan data campaign baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'           => 'required|image|mimes:png,jpg,jpeg|max:2000',
            'title'           => 'required|string|max:255',
            'category_id'     => 'required|exists:categories,id',
            'target_donation' => 'required|numeric',
            'max_date'        => 'required|date',
            'description'     => 'required|string',
        ]);

        $image = $request->file('image');
        $image->storeAs('public/campaigns', $image->hashName());

        Campaign::create([
            'image'           => $image->hashName(),
            'title'           => $request->title,
            'slug'            => Str::slug($request->title, '-'),
            'category_id'     => $request->category_id,
            'target_donation' => $request->target_donation,
            'max_date'        => $request->max_date,
            'description'     => $request->description,
            'user_id'         => Auth::id(),
        ]);

        return redirect()->route('campaign.index')->with(['success' => 'Data Campaign Berhasil Disimpan!']);
    }

    /**
     * Menampilkan form untuk mengedit campaign.
     */
    public function edit(Campaign $campaign)
    {
        $categories = Category::latest()->get();
        return view('pages.campaign.edit', compact('campaign', 'categories'));
    }

    /**
     * Memperbarui data campaign di database.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'category_id'     => 'required|exists:categories,id',
            'target_donation' => 'required|numeric',
            'max_date'        => 'required|date',
            'description'     => 'required|string',
            'image'           => 'nullable|image|mimes:png,jpg,jpeg|max:2000',
        ]);

        $campaignData = $request->except('image');
        $campaignData['slug'] = Str::slug($request->title, '-');

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('campaigns/' . $campaign->getRawOriginal('image'));
            $image = $request->file('image');
            $image->storeAs('public/campaigns', $image->hashName());
            $campaignData['image'] = $image->hashName();
        }

        $campaign->update($campaignData);

        return redirect()->route('campaign.index')->with(['success' => 'Data Campaign Berhasil Diupdate!']);
    }

    /**
     * Menghapus data campaign dari database.
     */
    public function destroy(Campaign $campaign)
    {
        $imageNameToDelete = $campaign->getRawOriginal('image');

        if ($campaign->delete()) {
            if ($imageNameToDelete) {
                Storage::disk('public')->delete('campaigns/' . $imageNameToDelete);
            }
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}