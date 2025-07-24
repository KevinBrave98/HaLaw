<?php

namespace App\Http\Controllers;
use App\Models\Riwayat;
use App\Models\Pengacara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LawyerDashboardController extends Controller
{
    public function dashboard()
    {
        $pengacara = Pengacara::where('email', Auth::guard('lawyer')->user()->email)->first();
        $status_konsultasi = $pengacara->status_konsultasi;
        $totalPendapatan = $pengacara->total_pendapatan;

        $penilaian = DB::table('pengacaras')
        ->join('riwayats', 'pengacaras.nik_pengacara', '=', 'riwayats.nik_pengacara')
        ->where('pengacaras.nik_pengacara', $pengacara->nik_pengacara)
        ->avg('riwayats.penilaian');
        return view('lawyer.dashboard', compact('pengacara', 'status_konsultasi', 'totalPendapatan', 'penilaian'));
    }

    public function toggleStatus()
    {
        $pengacara = Pengacara::where('email', Auth::guard('lawyer')->user()->email)->first();
        $newStatus = $pengacara->status_konsultasi == 1 ? 0 : 1;

        DB::table('pengacaras')
            ->where('nama_pengacara', $pengacara->nama_pengacara)
            ->update(['status_konsultasi' => $newStatus]);

        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }

    public function updateLayanan(Request $request)
    {
        $pengacara = Pengacara::where('email', Auth::guard('lawyer')->user()->email)->first();
        DB::table('pengacaras')->where('nik_pengacara', $pengacara->nik_pengacara)->update([
            'chat' => $request->has('chat') ? 1 : 0,
            'voice_chat' => $request->has('voice_chat') ? 1 : 0,
            'video_call' => $request->has('video_call') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Layanan diperbarui.');
    }
}
