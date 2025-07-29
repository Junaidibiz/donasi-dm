<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::with('user', 'sumDonation')
            ->when($request->q, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->q . '%');
            })
            ->latest()
            ->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List Data Campaigns',
            'data'    => $campaigns,
        ], 200);
    }

    public function show($slug)
    {
        // Memuat SEMUA relasi yang dibutuhkan dalam satu query
        $campaign = Campaign::with(['user', 'sumDonation', 'donations.donatur', 'expenseReports'])
                            ->where('slug', $slug)
                            ->firstOrFail();

        // Cukup kembalikan resource, Laravel akan menanganinya
        return new CampaignResource($campaign);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $campaigns = Campaign::with('user', 'sumDonation')
                            ->where('title', 'like', '%' . $keyword . '%')
                            ->latest()
                            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'List Data Campaign : ' . $keyword,
            'data'    => $campaigns
        ]);
    }
}