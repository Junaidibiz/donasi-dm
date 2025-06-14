<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;

class CampaignController extends Controller
{
    /**
     * Menampilkan semua campaign dengan paginasi.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Ambil data campaign dengan relasi user dan total donasi
        $campaigns = Campaign::with('user', 'sumDonation')
            ->when(request()->q, function ($query) {
                $query->where('title', 'like', '%' . request()->q . '%');
            })
            ->latest()
            ->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List Data Campaigns',
            'data'    => $campaigns,
        ], 200);
    }

    /**
     * Menampilkan detail campaign beserta donasi yang masuk.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        // Ambil detail campaign
        $campaign = Campaign::with('user', 'sumDonation')->where('slug', $slug)->first();

        if ($campaign) {
            // Ambil donasi untuk campaign ini
            $donations = Donation::with('donatur')->where('campaign_id', $campaign->id)
                ->where('status', 'success')
                ->latest()
                ->get();

            return response()->json([
                'success'   => true,
                'message'   => 'Detail Data Campaign: ' . $campaign->title,
                'data'      => $campaign,
                'donations' => $donations
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Campaign Tidak Ditemukan!',
        ], 404);
    }
}