<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // <-- Tambahkan ini

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Menggunakan Validator::make() agar response error sama dengan referensi
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Status 422 lebih standar untuk validasi
        }

        // Cari donatur berdasarkan email
        $donatur = Donatur::where('email', $request->email)->first();

        // Cek donatur dan verifikasi password
        if (!$donatur || !Hash::check($request->password, $donatur->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah.',
            ], 401);
        }

        // Buat token menggunakan Sanctum
        $token = $donatur->createToken('auth_token')->plainTextToken;

        // Return response dengan token
        return response()->json([
            'success'       => true,
            'message'       => 'Login Berhasil!',
            'donatur'       => $donatur,
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Logout Berhasil!',
        ]);
    }
}