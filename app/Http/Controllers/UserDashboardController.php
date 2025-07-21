<?php

namespace App\Http\Controllers;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use App\Http\Controllers\Pengguna;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\pengacara;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function greetings()
    {
        $pengacara = DB::table('pengacaras')->inRandomOrder()->limit(5)->get();
        $pengguna = Auth::user();
        $konsultasi = Riwayat::findOrFail(0);
        $konsultasi->status = 'dibatalkan';
        $konsultasi->save();
        return view('user.dashboard_user', compact('pengacara', 'pengguna'));
    }
}
