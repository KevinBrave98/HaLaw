<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardView() {
        if(Auth::guard('web')->check()) {
            return redirect()->route('dashboard.user', ['nama_pengguna' => Auth::user()->nama_pengguna]);
        } else if (Auth::guard('lawyer')->check()) {
            return redirect()->route('lawyer.dashboard', ['nama_pengacara' => Auth::guard('lawyer')->user()->nama_pengacara]);
        } else {
            return view('dashboard_pengguna_dan_pengacara_sebelum_login');
        }
    }
}
