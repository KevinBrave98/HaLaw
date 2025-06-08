<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\pengacara;
use Ramsey\Uuid\Type\Integer;

class UserDashboardController extends Controller
{
    public function greetings(string $nama_pengguna){
        $pengacara = DB::table('pengacaras')->inRandomOrder()->limit(5)->get();

        return view('dashboard_user', compact('nama_pengguna', 'pengacara'));
    }

//     public function pengacara(string $nama_pengacara, string $spesialisasi, int $tarif_jasa){
//         return view('dashboard_user')->with('nama_pengacara',)
//     }
}
