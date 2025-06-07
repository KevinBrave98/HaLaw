<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardView() {
        if(Auth::guard('web')->check()) {
            return view('dashboard_user');
        } else if(Auth::guard('lawyer')->check()) {
            return view('dashboard_pengguna_dan_pengacara_sebelum_login');
        } else {
            return view('dashboard_pengguna_dan_pengacara_sebelum_login');
        }
    }
}
