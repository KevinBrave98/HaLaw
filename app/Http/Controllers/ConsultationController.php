<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Pesan;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ConsultationController extends Controller
{
    public function index($id)
    {
        $riwayat = Riwayat::where('id_riwayat', $id)->first();
        if ($riwayat) {
            $pesan = $riwayat->pesans;
        } else {
            if (Auth::guard('web')->check()) {
                return redirect()->route('dashboard.user');
            } else if (Auth::guard('lawyer')->check()) {
                return redirect()->route('lawyer.dashboard');
            } else {
                return redirect()->route('dashboard.sebelum_login');
            }
        }
        if (Auth::guard('web')->check()) {
            return view('user.user_discussion', compact('riwayat', 'pesan'));
        } else if (Auth::guard('lawyer')->check()) {
            return view('lawyer.lawyer_discussion', compact('riwayat', 'pesan'));
        } else {
            return redirect()->route('dashboard.sebelum_login');
        }
    }

    public function send(Request $request, $id)
    {
        $request->validate(['teks' => 'required|string']);

        $pesan = new Pesan();
        if (Auth::guard('web')->check()) {
            $pesan->nik = Auth::user()->nik_pengguna;
        } else {
            $pesan->nik = Auth::guard('lawyer')->user()->nik_pengacara;
        }
        $pesan->teks = $request->teks;
        $pesan->id_riwayat = $id;

        $pesan->save();
        broadcast(new MessageSent($pesan))->toOthers();


        return response()->json([
            'status' => 'success',
            'message' => 'Pesan sent.',
            'data' => $pesan
        ]);
    }
}
