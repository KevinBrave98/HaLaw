<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Pengguna;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function greetings(string $nama_pengguna){
        return view('dashboard_user')->with('nama_pengguna', $nama_pengguna);
    }
}
