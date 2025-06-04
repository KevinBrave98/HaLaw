<?php

namespace App\Http\Controllers;
use App\Models\Pengacara;
use Illuminate\Http\Request;

class LawyerDashboardController extends Controller
{
    public function greetings(string $nama_pengacara) 
    {
        return view ('lawyer.dashboard')->with('nama_pengacara', $nama_pengacara);
    }
}