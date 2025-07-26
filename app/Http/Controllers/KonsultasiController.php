<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KonsultasiController extends Controller
{
    public function konsultasiSedangBerlangsung()
    {
        $nik_pengguna = Auth::user()->nik_pengguna;

        $riwayats = Riwayat::where('nik_pengguna', $nik_pengguna)->where('status', "Sedang Berlangsung")->orWhere('status', "Menunggu Konfirmasi")->get();

        return response()
            ->view('user.konsultasi_sedang_berlangsung', compact('riwayats'));
            // ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            // ->header('Pragma', 'no-cache')
            // ->header('Expires', '0');
    }

    public function konsultasiSedangBerlangsungPengacara() {
        $nik_pengacara = Auth::guard('lawyer')->user()->nik_pengacara;
        $riwayats = Riwayat::where('nik_pengacara', $nik_pengacara)->where('status', "Sedang Berlangsung")->orWhere('status', "Menunggu Konfirmasi")->get();
        return view('lawyer.konsultasi_sedang_berlangsung', compact('riwayats'));
    }

    public function riwayatKonsultasi() {
        $nik_pengguna = Auth::user()->nik_pengguna;

        $riwayats = Riwayat::where('nik_pengguna', $nik_pengguna)
            ->whereIn('status', ['Selesai', 'Dibatalkan'])
            ->orderBy('created_at', 'desc') // pakai created_at sebagai pengganti 'tanggal'
            ->get();

        return view('user.riwayat_konsultasi', compact('riwayats'));
    }
}
