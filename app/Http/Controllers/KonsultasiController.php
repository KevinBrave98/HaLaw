<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KonsultasiController extends Controller
{
    public function redirectChat() {
        return redirect()->route('konsultasi.berlangsung');
    }
    public function konsultasiSedangBerlangsung()
    {
        $nik_pengguna = Auth::user()->nik_pengguna;

        $riwayats = Auth::user()->riwayats()
            ->where('status', 'Sedang Berlangsung')
            ->orWhere('status', 'Menunggu Konfirmasi')
            ->get();
        // $riwayats =  $riwayat->where('status', 'Sedang Berlangsung')->orWhere('status', 'Menunggu Konfirmasi')->get();
        return response()->view('user.konsultasi_sedang_berlangsung', compact('riwayats'));
        // ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        // ->header('Pragma', 'no-cache')
        // ->header('Expires', '0');
    }

    public function konsultasiSedangBerlangsungPengacara()
    {
        $nik_pengacara = Auth::guard('lawyer')->user()->nik_pengacara;
        // $riwayats = Riwayat::where('nik_pengacara', $nik_pengacara)->where('status', 'Sedang Berlangsung')->orWhere('status', 'Menunggu Konfirmasi')->get();
        $riwayats = Auth::guard('lawyer')->user()->riwayats()
            ->where('status', 'Sedang Berlangsung')
            ->orWhere('status', 'Menunggu Konfirmasi')
            ->get();
        return view('lawyer.konsultasi_sedang_berlangsung', compact('riwayats'));
    }

    public function riwayatKonsultasi(Request $request)
    {
        $nik_pengguna = Auth::user()->nik_pengguna;

        // Ambil input dari request
        $status = $request->input('status'); // contoh: 'Selesai' atau 'Dibatalkan'
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        // Query dasar
        $query = \App\Models\Riwayat::with('pengacara') // pastikan relasi dipanggil
            ->where('nik_pengguna', $nik_pengguna)
            ->whereIn('status', ['Selesai', 'Dibatalkan']);

        // Filter berdasarkan status jika ada
        if (!is_null($status) && $status !== '') {
            $query->where('status', $status);
        }

        // Filter berdasarkan rentang tanggal jika lengkap
        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('created_at', '>=', $tanggal_awal)->whereDate('created_at', '<=', $tanggal_akhir);
        }

        // Urutkan berdasarkan waktu terbaru
        $riwayats = $query->orderBy('created_at', 'desc')->get();

        return view('user.riwayat_konsultasi', compact('riwayats', 'status', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function riwayatKonsultasiPengacara(Request $request)
    {
        $nik_pengacara = Auth::guard('lawyer')->user()->nik_pengacara;

        // Ambil input dari request
        $status = $request->input('status'); // contoh: 'Selesai' atau 'Dibatalkan'
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        // Query dasar
        $query = \App\Models\Riwayat::with('pengguna') // pastikan relasi dipanggil
            ->where('nik_pengacara', $nik_pengacara)
            ->whereIn('status', ['Selesai', 'Dibatalkan']);

        // Filter berdasarkan status jika ada
        if (!is_null($status) && $status !== '') {
            $query->where('status', $status);
        }

        // Filter berdasarkan rentang tanggal jika lengkap
        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereDate('created_at', '>=', $tanggal_awal)->whereDate('created_at', '<=', $tanggal_akhir);
        }

        // Urutkan berdasarkan waktu terbaru
        $riwayats = $query->orderBy('created_at', 'desc')->get();

        return view('lawyer.riwayat_konsultasi', compact('riwayats', 'status', 'tanggal_awal', 'tanggal_akhir'));
    }
}
