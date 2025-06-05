<?php

namespace App\Http\Controllers;
use App\Models\Pengacara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LawyerDashboardController extends Controller
{
    public function greetings() 
    {
        $nama_pengacara = DB::table('pengacara') -> value('nama_pengacara');
        return view ('lawyer.dashboard')->with('nama_pengacara', $nama_pengacara);
    }
}