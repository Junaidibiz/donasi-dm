<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Menangani permintaan registrasi donatur baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Set validasi
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:donaturs',
            'password'  => 'required|string|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Buat donatur baru
        $donatur = Donatur::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        // Buat token menggunakan Sanctum
        $token = $donatur->createToken('auth_token')->plainTextToken;

        // Return response dengan token
        return response()->json([
            'success'       => true,
            'message'       => 'Registrasi Berhasil!',
            'donatur'       => $donatur,
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ], 201);
    }
}