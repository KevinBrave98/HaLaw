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
    public function greetings(){
        $pengacara = DB::table('pengacaras')->inRandomOrder()->limit(5)->get();
        $pengguna = Auth::user();
        return view('user.dashboard_user', compact('pengacara', 'pengguna'));
    }
}
