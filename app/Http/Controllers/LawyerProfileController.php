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
        $user = Auth::guard('lawyer')->user()->load('spesialisasis'); //ambil data pengguna berdasarkan sesi login yang aktif return view('profil_pengacara', compact('user'));
        return view('lawyer.profil_pengacara', compact('user'));  // compact('user') dipakai untuk kirim data $user ke blade 'profil_pengacara'
    }
    public function edit()
    {
        $user = Auth::guard('lawyer')->user();
        return view('lawyer.ubah_profil_pengacara', compact('user'));  // compact('user') dipakai untuk kirim data $user ke blade 'profil_pengacara'
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
            'durasi_pengalaman' => 'required',
            'spesialisasi' => ['required', 'string', Rule::in(['Hukum Perdata', 'Hukum Pidana', 'Hukum Keluarga', 'Hukum Perusahaan', 'Hukum Hak Kekayaan Intelektual', 'Hukum Pajak', 'Hukum Kepalitan', 'Hukum Lingkungan Hidup', 'Hukum Kepentingan Publik', 'Hukum Ketenagakerjaan', 'Hukum Tata Usaha Negara', 'Hukum Imigrasi'])],
            'jenis_kelamin' => ['required', Rule::in(['Laki - Laki', 'Perempuan', 'Memilih Tidak Menjawab'])],
            'foto_pengacara' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // maksimal 2MB
        ]);

        $user->fill($validated);

        if ($request->hasFile('foto_pengacara')) {
            $fotoBaru = $request->file('foto_pengacara')->store('foto_pengacara', 'public');

            // hapus foto lama kalau ada
            if ($user->foto_pengacara && Storage::disk('public')->exists($user->foto_pengacara)) {
                Storage::disk('public')->delete($user->foto_pengacara);
            }

            $user->foto_pengacara = $fotoBaru;
        }

        $user->save();

        return redirect()->route('lawyer.profile.show')->with('success', 'Profil berhasil diperbarui');
    }
}
