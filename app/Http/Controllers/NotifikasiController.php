<?php
namespace App\Http\Controllers;

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
}
