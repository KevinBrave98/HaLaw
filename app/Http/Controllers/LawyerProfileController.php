<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;

class LawyerProfileController extends Controller
{
    public function show()
    {
        $user = Auth::guard('lawyer')->user(); //ambil data pengguna berdasarkan sesi login yang aktifreturn view('profil_pengacara', compact('user'));
        return view('profil_pengacara', compact('user'));  // compact('user') dipakai untuk kirim data $user ke blade 'profil_pengacara'
    }
    public function edit()
    {
        $user = Auth::user();
        return view('ubah_profil_pengacara', compact('user'));  // compact('user') dipakai untuk kirim data $user ke blade 'profil_pengacara'
    }
    public function exit()
    {
        Auth::guard('lawyer')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login.show');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Pengacara $user **/
        $user =  Auth::guard('lawyer')->user();

        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nik' => ['required', 'min:16', 'max:16', Rule::unique('penggunas', 'nik_pengguna')->ignore($user->nik_pengguna, 'nik_pengguna')],
            'email' => ['required', 'email', Rule::unique('penggunas', 'email')->ignore($user->nik_pengguna, 'nik_pengguna')],
            'nomor_telepon' => ['required', 'min:11', 'max:12', Rule::unique('penggunas', 'nomor_telepon')->ignore($user->nik_pengguna, 'nik_pengguna')],
            'lokasi_praktik' => 'required|string|max:255',
            'tarifJasa' => 'required|numeric|min:0',
            'pengalamanBekerja' => 'string',
            'pendidikan' => 'string',
            'durasipengalaman' => 'required',
            'spesialisasi' => ['required', 'string', Rule::in(['Hukum Perdata', 'Hukum Pidana', 'Hukum Keluarga', 'Hukum Perusahaan', 'Hukum Hak Kekayaan Intelektual', 'Hukum Pajak', 'Hukum Kepalitan', 'Hukum Lingkungan Hidup', 'Hukum Kepentingan Publik', 'Hukum Ketenagakerjaan', 'Hukum Tata Usaha Negara', 'Hukum Imigrasi'])],
            'jenis_kelamin' => ['required', Rule::in(['Laki - Laki', 'Perempuan', 'Memilih Tidak Menjawab'])],
        ]);

        $user->fill($validated);

        if ($request->hasFile('foto_pengguna')) {
            $fotoBaru = $request->file('foto_pengguna')->store('foto_pengguna', 'public');

            // hapus foto lama kalau ada
            if ($user->foto_pengguna && Storage::disk('public')->exists($user->foto_pengguna)) {
                Storage::disk('public')->delete($user->foto_pengguna);
            }

            $user->foto_pengguna = $fotoBaru;
        }

        $user->save();

        return redirect()->route('lawyer.profile.show')->with('success', 'Profil berhasil diperbarui');
    }
}
