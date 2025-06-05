<?php

namespace App\Http\Controllers;
use App\Models\Pengacara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LawyerDashboardController extends Controller
{
    public function dashboard()
    {
        $nama_pengacara = DB::table('pengacara')->value('nama_pengacara');
        $status_konsultasi = DB::table('pengacara')->value('status_konsultasi');
        $layanan_konsultasi = DB::table('pengacara')->value('preferensi_komunikasi');
        return view('lawyer.dashboard', compact('nama_pengacara', 'status_konsultasi', 'layanan_konsultasi'));
    }

    public function toggleStatus()
    {
        $nama_pengacara = DB::table('pengacara')->value('nama_pengacara');
        $pengacara = DB::table('pengacara')->where('nama_pengacara', $nama_pengacara)->first();

        $newStatus = $pengacara->status_konsultasi === 'online' ? 'offline' : 'online';

        DB::table('pengacara')->update([
            'status_konsultasi' => $newStatus
        ]);

        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }

    public function updateLayanan(Request $request)
    {
        $request->validate([
            'preferensi_komunikasi' => 'nullable|array',
            'preferensi_komunikasi.*' => 'string',
        ]);

        $nama_pengacara = DB::table('pengacara')->value('nama_pengacara');

        $preferensi_komunikasi = $request->input('preferensi_komunikasi', []);
        $layananStr = implode(',', $preferensi_komunikasi);

        DB::table('pengacara')->where('nama_pengacara', $nama_pengacara)->update([
            'preferensi_komunikasi' => $layananStr
        ]);

        return redirect()->back()->with('success', 'Preferensi layanan berhasil diperbarui.');
    }
}