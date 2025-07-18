<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use App\Notifications\DonaturResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Mengirim link reset password ke email donatur.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:donaturs,email']);

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        $donatur = Donatur::where('email', $request->email)->first();
        $donatur->notify(new DonaturResetPasswordNotification($token));
        
        return response()->json([
            'success' => true,
            'message' => 'Link reset password telah dikirim ke email Anda!',
        ]);
    }

    /**
     * Mereset password donatur.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:donaturs,email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string',
        ]);

        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return response()->json(['success' => false, 'message' => 'Token reset password tidak valid.'], 400);
        }

        $donatur = Donatur::where('email', $request->email)->first();
        $donatur->password = Hash::make($request->password);
        $donatur->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password Anda telah berhasil direset!',
        ]);
    }
}