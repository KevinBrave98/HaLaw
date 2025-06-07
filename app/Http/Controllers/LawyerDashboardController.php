<?php

namespace App\Http\Controllers;
use App\Models\Pengacara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LawyerDashboardController extends Controller
{
    public function dashboard()
    {
        // $pengacara = DB::table('pengacaras')->where('email', auth()->user()->email)->first();
        $pengacara = DB::table('pengacaras')->where('nik_pengacara', '9876543210123456')->first();
        // dd($pengacara);
        $status_konsultasi = DB::table('pengacaras')->value('status_konsultasi');
        $totalPendapatan = DB::table('pengacaras')
        ->join('riwayat_danas', 'pengacaras.nik_pengacara', '=', 'riwayat_danas.nik_pengacara')
        ->where('pengacaras.nik_pengacara', '9876543210123456') // Hardcoded for now
        ->sum('riwayat_danas.nominal');

        $penilaian = DB::table('pengacaras')
        ->join('riwayats', 'pengacaras.nik_pengacara', '=', 'riwayats.nik_pengacara')
        ->where('pengacaras.nik_pengacara', '9876543210123456') // Hardcoded for now
        ->avg('riwayats.penilaian');
        return view('lawyer.dashboard', compact('pengacara', 'status_konsultasi', 'totalPendapatan', 'penilaian'));
    }

    public function toggleStatus()
    {
        // $pengacara = DB::table('pengacaras')->where('email', auth()->user()->email)->first();
        $pengacara = DB::table('pengacaras')->where('nik_pengacara', '9876543210123456')->first();
        $newStatus = $pengacara->status_konsultasi == 1 ? 0 : 1;

        DB::table('pengacaras')
            ->where('nama_pengacara', $pengacara->nama_pengacara)
            ->update(['status_konsultasi' => $newStatus]);

        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }

    public function updateLayanan(Request $request)
    {
        $pengacara = DB::table('pengacaras')->where('nik_pengacara', '9876543210123456')->first();
        // $pengacara = DB::table('pengacaras')->where('email', auth()->user()->email)->first();
        DB::table('pengacaras')->where('nik_pengacara', '9876543210123456')->update([
            'chat' => $request->has('chat') ? 1 : 0,
            'voice_chat' => $request->has('voice_chat') ? 1 : 0,
            'video_call' => $request->has('video_call') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Layanan diperbarui.');
    }
}