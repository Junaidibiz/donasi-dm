<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class DonationController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    /**
     * Menampilkan riwayat donasi dari donatur yang sedang login.
     */
    public function index(Request $request)
    {
        $donations = Donation::with('campaign')
            ->where('donatur_id', $request->user()->id)
            ->latest()
            ->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List Data Donations: ' . $request->user()->name,
            'data'    => $donations,
        ], 200);
    }

    /**
     * Membuat transaksi donasi baru dan mendapatkan Snap Token dari Midtrans.
     */
    public function store(Request $request)
    {
        return DB::transaction(function() use ($request) {
            $request->validate([
                'amount'        => 'required|numeric|min:10000',
                'pray'          => 'nullable|string',
                'campaign_slug' => 'required|string|exists:campaigns,slug',
            ]);

            $campaign = Campaign::where('slug', $request->campaign_slug)->firstOrFail();

            $donation = Donation::create([
                'invoice'       => 'TRX-' . Str::upper(Str::random(10)),
                'campaign_id'   => $campaign->id,
                'donatur_id'    => $request->user()->id,
                'amount'        => $request->amount,
                'pray'          => $request->pray,
                'status'        => 'pending',
            ]);

            $payload = [
                'transaction_details' => [
                    'order_id'      => $donation->invoice,
                    'gross_amount'  => $donation->amount,
                ],
                'customer_details' => [
                    'first_name' => $donation->donatur->name,
                    'email'      => $donation->donatur->email,
                ],
            ];

            $snapToken = Snap::getSnapToken($payload);
            $donation->snap_token = $snapToken;
            $donation->save();

            return response()->json([
                'success' => true,
                'message' => 'Donasi Berhasil Dibuat!',
                'data'    => [
                    'snap_token' => $snapToken
                ]
            ], 201);
        });
    }

    /**
     * Menangani notifikasi dari Midtrans.
     */
    public function notificationHandler(Request $request)
    {
        $notification = json_decode($request->getContent());
        $signatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.server_key'));

        if ($notification->signature_key != $signatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        $donation = Donation::where('invoice', $orderId)->first();

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                $donation->update(['status' => ($fraud == 'challenge') ? 'pending' : 'success']);
            }
        } elseif ($transaction == 'settlement') {
            $donation->update(['status' => 'success']);
        } elseif ($transaction == 'pending') {
            $donation->update(['status' => 'pending']);
        } elseif ($transaction == 'deny' || $transaction == 'cancel') {
            $donation->update(['status' => 'failed']);
        } elseif ($transaction == 'expire') {
            $donation->update(['status' => 'expired']);
        }

        return response(['message' => 'Notification Handled'], 200);
    }
}