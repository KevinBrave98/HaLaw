<?php

namespace App\Http\Controllers;
use App\Models\Riwayat;
use App\Models\Pengacara;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use App\Http\Controllers\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function greetings(){
        $lawyers = Pengacara::where('status_konsultasi', 1);
        $harga_max = $lawyers->max('tarif_jasa');
        $harga_min = $lawyers->min('tarif_jasa');

        if($harga_max % 1000 != 0) {
            $harga_max += 1000 - ($harga_max % 1000);
            // dd($harga_max);
        }

        if($harga_min % 1000 != 0) {
            $harga_min -= 1000 + ($harga_min % 1000);
        }

        $pengacara = DB::table('pengacaras')->inRandomOrder()->limit(5)->get();
        $pengguna = Auth::user();
        return view('user.dashboard_user', compact('pengacara', 'pengguna', 'harga_max', 'harga_min'));
    }
}
