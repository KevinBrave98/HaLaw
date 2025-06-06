<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(){
        return view('profil_pengguna');
    }
    public function edit(){
        return view('ubah_profil_pengguna');
    }
     public function exit(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login.show');
    }
}
