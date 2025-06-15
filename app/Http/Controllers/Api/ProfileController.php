<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Mengembalikan data profil donatur yang sedang login.
     */
    public function index(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Data Profile',
            'data'    => $request->user(), // Ambil user dari request yang sudah terotentikasi
        ], 200);
    }

    /**
     * Memperbarui data profil donatur.
     */
    public function update(Request $request)
    {
        $donatur = $request->user(); // Dapatkan donatur yang sedang login

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'string', 'email', 'max:255', Rule::unique('donaturs')->ignore($donatur->id)],
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
        ]);

        $donaturData = $request->only('name', 'email');

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($donatur->avatar) {
                Storage::disk('public')->delete('donaturs/' . $donatur->getRawOriginal('avatar'));
            }

            // Upload avatar baru
            $image = $request->file('avatar');
            $image->storeAs('public/donaturs', $image->hashName());
            $donaturData['avatar'] = $image->hashName();
        }

        $donatur->update($donaturData);

        return response()->json([
            'success' => true,
            'message' => 'Data Profile Berhasil Diupdate!',
            'data'    => $donatur,
        ], 200);
    }

    /**
     * Memperbarui password donatur.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $donatur = $request->user();
        $donatur->update([
            'password'  => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password Berhasil Diupdate!',
        ], 200);
    }
}