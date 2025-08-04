<?php

namespace App\Http\Controllers;

use App\Models\Kamus;
use App\Models\Pesan;
use App\Models\Riwayat;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class ConsultationController extends Controller
{
    public function index($id)
    {
        $riwayat = Riwayat::where('id', $id)->first();
        if ($riwayat) {
            $pesan = $riwayat->pesans;
        } else {
            if (Auth::guard('web')->check()) {
                return redirect()->route('konsultasi.berlangsung');
            } else if (Auth::guard('lawyer')->check()) {
                return redirect()->route('lawyer.dashboard');
            } else {
                return redirect()->route('dashboard.view');
            }
        }
        if (Auth::guard('web')->check()) {
            return view('user.user_discussion', compact('riwayat', 'pesan'));
        } else if (Auth::guard('lawyer')->check()) {
            return view('lawyer.lawyer_discussion', compact('riwayat', 'pesan'));
        } else {
            return redirect()->route('dashboard.view');
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
    // app/Http/Controllers/KamusController.php

    public function search(Request $request)
    {
        // 1. Sesuaikan nama input menjadi 'q' agar cocok dengan form Anda
        $query = $request->input('q');
        $results = [];

        if ($query) {
            // Aktifkan pencatatan query
            DB::enableQueryLog();

            $kamus = Kamus::query();
            $kamus->whereRaw('LOWER(istilah) LIKE ?', ['%' . strtolower($query) . '%']);
            $results = $kamus->orderBy('istilah')->limit(20)->get();

            // Catat query yang baru saja dijalankan ke file log
            Log::info(DB::getQueryLog());
        }

        return response()->json($results);
    }
}
