<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LawyerProfileController extends Controller
{
     public function show(){
        return view('profil_pengacara');
    }
    public function edit(){
        return view('ubah_profil_pengacara');
    }
}
