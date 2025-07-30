<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class PrayerController extends Controller
{
    public function index()
    {
        $donations = Donation::with('donatur', 'campaign')
                            ->whereNotNull('pray')
                            ->where('pray', '!=', '')
                            ->latest()
                            ->paginate(10);

        return view('pages.prayer.index', compact('donations'));
    }

    public function update(Request $request, Donation $donation)
    {
        $donation->update([
            'is_pray_visible' => !$donation->is_pray_visible
        ]);

        return back()->with('success', 'Status visibilitas doa berhasil diubah.');
    }
}