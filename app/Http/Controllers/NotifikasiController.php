<?php
namespace App\Http\Controllers;
use App\Models\Riwayat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function hapus($id)
    {
        $user = auth()->user();
        $notif = $user->unreadNotifications()->find($id);

        if ($notif) {
            $notif->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function hapusnotifpengacara($id)
    {
        $pengacara = Auth::guard('lawyer')->user(); // pastikan kamu pakai guard khusus kalau ada

        if (!$pengacara) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $notification = $pengacara->unreadNotifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);

    }
    
    // Cek apakah ada konsultasi baru
    public function cekNotifikasi()
    {
        $pengacara = Auth::guard('lawyer')->user();

        $notifikasi = DB::table('riwayats')
        ->join('penggunas', 'riwayats.nik_pengguna', '=', 'penggunas.nik_pengguna')
        ->where('riwayats.nik_pengacara', $pengacara->nik_pengacara)
        ->where('riwayats.status', 'menunggu konfirmasi')
        ->select('riwayats.*', 'penggunas.nama_pengguna as nama_pengguna')
        ->latest('riwayats.created_at')
        ->get();

        return response()->json([
            'ada_notifikasi' => $notifikasi->count() > 0,
            'data' => $notifikasi,
        ]);
    }

    public function konfirmasi($id)
    {
        $riwayat = Riwayat::find($id);

        if (!$riwayat) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        $riwayat->status = 'sedang berlangsung';
        $riwayat->save();

        return response()->json(['success' => true,
            'redirect' => route('consultation.lawyer', ['id' => $riwayat->id])]);
        
    }

    public function batalkan($id)
    {
        $riwayat = Riwayat::find($id);

        if (!$riwayat) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        $riwayat->status= 'dibatalkan';
        $riwayat->save();

        return response()->json(['success' => true]);
    }
}
