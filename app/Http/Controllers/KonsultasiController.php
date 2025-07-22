<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;
use Illuminate\Support\Facades\DB;

class KonsultasiController extends Controller
{
    public function konsultasiSedangBerlangsung()
    {
        $nik_pengguna = auth()->user()->nik_pengguna;

        $riwayats = DB::table('riwayats')
            ->join('pengacaras', 'riwayats.nik_pengacara', '=', 'pengacaras.nik_pengacara')
            ->where('riwayats.nik_pengguna', $nik_pengguna)
            ->where('riwayats.status', 'sedang berlangsung')
            ->orWhere('riwayats.status', 'menunggu konfirmasi')
            ->select(
                'riwayats.*',
                'pengacaras.nama_pengacara',
                'pengacaras.foto_pengacara',
                'pengacaras.spesialisasi',
                'pengacaras.durasi_pengalaman',
                'pengacaras.chat',
                'pengacaras.voice_chat',
                'pengacaras.video_call'
            )
            ->get();

        return view('user.konsultasi_sedang_berlangsung', compact('riwayats'));
    }
}
