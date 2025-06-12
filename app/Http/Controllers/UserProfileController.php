<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(){
        $user = Auth::user(); //ambil data pengguna berdasarkan sesi login yang aktif
        return view('profil_pengguna', compact('user')); // compact('user') dipakai untuk kirim data $user ke blade 'profil_pengguna'
    }
    public function edit(){
        $user = Auth::user();
        return view('ubah_profil_pengguna', compact('user'));
    }
    public function exit(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login.show');
    }

    public function update(Request $request){
        $user = Auth::user();

        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nomor_telepon' => [
                'required',
                'min:11',
                'max:12',
                Rule::unique('penggunas', 'nomor_telepon')->ignore($user->nik_pengguna, 'nik_pengguna'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('penggunas', 'email')->ignore($user->nik_pengguna, 'nik_pengguna'),
            ],
            'jenis_kelamin' => [
                'required',
                Rule::in(['Laki - Laki', 'Perempuan', 'Memilih Tidak Menjawab']),
            ],
            'alamat' => [
                'nullable',
                'max:255',
                'string'
            ]
        ]);

        /** @var \App\Models\Pengguna $user **/
        $user->fill($validated);


        if ($request->hasFile('foto_pengguna')) {
            $fotoBaru = $request->file('foto_pengguna')->store('foto_pengguna', 'public');

            // hapus foto lama kalau ada
            if ($user->foto_pengguna && Storage::disk('public')->exists($user->foto_pengguna)) {
                Storage::disk('public')->delete($user->foto_pengguna);
            }

            $user->foto_pengguna = $fotoBaru;
        }


        /** @var \App\Models\Pengguna $user **/
        $user->save();


        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui');
    }
}
