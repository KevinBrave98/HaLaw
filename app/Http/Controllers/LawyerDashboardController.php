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
        return view('lawyer.dashboard', compact('pengacara', 'status_konsultasi'));
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

        DB::table('pengacaras')->where('nik_pengacara', '9876543210123456')->update([
            'chat' => $request->has('chat') ? 1 : 0,
            'voice_chat' => $request->has('voice_chat') ? 1 : 0,
            'video_call' => $request->has('video_call') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Layanan diperbarui.');
    }
}