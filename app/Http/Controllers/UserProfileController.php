<?php

namespace App\Http\Controllers;

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
        return view('dashboard_sebelum_login');
    }
}
