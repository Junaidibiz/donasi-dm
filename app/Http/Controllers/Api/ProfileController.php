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
            'data'    => $request->user(), // Mengembalikan user dengan accessor avatar
        ], 200);
    }

    /**
     * Memperbarui data profil donatur.
     */
    public function update(Request $request)
    {
        $donatur = $request->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('donaturs')->ignore($donatur->id)],
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2000', // Validasi avatar jika diupload
        ]);

        $donaturData = $request->only('name', 'email');

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($donatur->avatar) {
                // Pastikan Anda menghapus file yang benar di storage
                // 'getRawOriginal('avatar')' mengambil nilai mentah dari kolom DB
                Storage::disk('public')->delete('donaturs/' . $donatur->getRawOriginal('avatar'));
            }

            // Upload avatar baru
            $image = $request->file('avatar');
            $image->storeAs('public/donaturs', $image->hashName()); // Simpan di storage/app/public/donaturs
            $donaturData['avatar'] = $image->hashName(); // Simpan hanya nama file di DB
        } else if ($request->has('avatar') && $request->input('avatar') === '') {
            // Jika frontend mengirim 'avatar' sebagai string kosong, berarti ingin menghapus
            if ($donatur->avatar) {
                Storage::disk('public')->delete('donaturs/' . $donatur->getRawOriginal('avatar'));
            }
            $donaturData['avatar'] = null; // Set di DB menjadi NULL
        }


        $donatur->update($donaturData);

        return response()->json([
            'success' => true,
            'message' => 'Data Profile Berhasil Diupdate!',
            'data'    => $donatur, // Mengembalikan donatur yang sudah diupdate (dengan accessor avatar)
        ], 200);
    }

    /**
     * Menghapus avatar donatur (mengubah kolom avatar menjadi NULL).
     * Ini adalah method baru untuk endpoint /profile/remove-avatar
     */
    public function removeAvatar(Request $request)
    {
        $donatur = $request->user();

        if ($donatur->avatar) {
            // Hapus file avatar fisik dari storage
            // 'getRawOriginal('avatar')' mengambil nilai mentah dari kolom DB (nama file)
            Storage::disk('public')->delete('donaturs/' . $donatur->getRawOriginal('avatar'));

            // Set kolom 'avatar' di database menjadi NULL
            $donatur->update(['avatar' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus!',
                'data'    => $donatur->fresh(), // Ambil data donatur terbaru setelah update
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada foto profil untuk dihapus.',
        ], 404); // Atau 400 Bad Request
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