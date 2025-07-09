<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request; // Import Request
use App\Http\Resources\CampaignResource;
use App\Http\Resources\DonationResource;

class CampaignController extends Controller
{
    /**
     * Menampilkan semua campaign dengan paginasi.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) // Tambahkan Request $request
    {
        $campaigns = Campaign::with('user', 'sumDonation')
            ->when($request->q, function ($query) use ($request) { // Gunakan $request->q
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

    /**
     * Menampilkan detail campaign beserta donasi yang masuk.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        // Ambil detail campaign dengan relasi yang dibutuhkan
        $campaign = Campaign::with('user', 'sumDonation')->where('slug', $slug)->first();

        if ($campaign) {
            // Ambil donasi untuk campaign ini dengan relasinya
            $donations = Donation::with('donatur')
                ->where('campaign_id', $campaign->id)
                ->where('status', 'success')
                ->latest()
                ->get();

            // Kembalikan response menggunakan API Resources
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Data Campaign: ' . $campaign->title,
                'data'      => new CampaignResource($campaign), // Gunakan CampaignResource
                'donations' => DonationResource::collection($donations) // Gunakan DonationResource untuk koleksi
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Campaign Tidak Ditemukan!',
        ], 404);
    }

    /**
     * API untuk mencari campaign berdasarkan kata kunci.
     * Mengembalikan data dalam format JSON.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $keyword = $request->keyword; // Mengambil kata kunci dari parameter 'keyword'

        // Lakukan pencarian campaign berdasarkan judul
        $campaigns = Campaign::with('user', 'sumDonation')
                        ->where('title', 'like', '%' . $keyword . '%')
                        ->latest()
                        ->paginate(10); // Atau paginate(5) jika ingin konsisten dengan index()

        return response()->json([
            'success' => true,
            'message' => 'List Data Campaign : ' . $keyword,
            'data'    => $campaigns // Laravel's paginate secara otomatis menyertakan data dalam kunci 'data'
        ]);
    }
}