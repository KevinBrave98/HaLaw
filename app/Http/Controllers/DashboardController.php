<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardView() {
        if(Auth::guard('web')->check()) {
            return redirect()->route('dashboard.user');
        } else if (Auth::guard('lawyer')->check()) {
            return redirect()->route('lawyer.dashboard');
        } else {
            return view('dashboard_sebelum_login');
        }
    }
}
