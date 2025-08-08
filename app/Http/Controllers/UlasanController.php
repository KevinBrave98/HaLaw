<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UlasanController extends Controller
{
    public function index($id)
    {
        $riwayat = Riwayat::where('id', $id)->first();
        if (!$riwayat) {
                return redirect()->route('riwayat.konsultasi');
        }
        if($riwayat->status == 'Menunggu Konfirmasi' || $riwayat->status == 'Sedang Berlangsung' || $riwayat->status == 'Dibatalkan') {
            return redirect()->route('riwayat.konsultasi');
        }
        $sudahReview = !is_null($riwayat->penilaian);
        return view('user.ulasan', compact('id', 'riwayat', 'sudahReview'));
    }

    public function submit(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate(
            [
                'rating' => 'required|integer|min:1|max:5',
                'ulasan' => 'required|string|max:1000|min:10',
            ],
            [
                'rating.required' => 'Penilaian bintang wajib diisi.',
                'rating.integer' => 'Penilaian harus berupa angka.',
                'rating.min' => 'Penilaian minimal 1 bintang.',
                'rating.max' => 'Penilaian maksimal 5 bintang.',
                'ulasan.required' => 'Ulasan wajib diisi.',
                'ulasan.min' => 'Ulasan minimal 10 karakter.',
                'ulasan.max' => 'Ulasan maksimal 1000 karakter.',
            ],
        );

        try {
            // Menggunakan Eloquent untuk menyimpan data
            $riwayat = Riwayat::where('id', $id)->first();
            $riwayat->penilaian = $validated['rating']; // Rating bintang (1-5)
            $riwayat->ulasan = $validated['ulasan'];
            $riwayat->save();

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda telah berhasil dikirim.');
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error menyimpan ulasan: ' . $e->getMessage(), [
                'user_nik' => Auth::user()->nik ?? null,
                'id' => $id,
                'data' => $validated,
            ]);

            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Maaf, terjadi kesalahan saat menyimpan ulasan. Silakan coba lagi.')->withInput();
        }
    }

    public function lawyerIndex() {
        $riwayat = Auth::guard('lawyer')->riwayats;
        $sudahReview = !is_null($riwayat->penilaian);
        return view('lawyer.ulasan', compact('sudahReview'));
    }
}
