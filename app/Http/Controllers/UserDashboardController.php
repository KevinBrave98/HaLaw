<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use App\Http\Controllers\Pengguna;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\pengacara;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function greetings(string $nama_pengguna){
        $pengacara = DB::table('pengacaras')->inRandomOrder()->limit(5)->get();
        $pengguna = Auth::user();
        return view('dashboard_user', compact('nama_pengguna', 'pengacara', 'pengguna'));
    }
}
