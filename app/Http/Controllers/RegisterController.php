<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //

    public function showUser(){
        return view('user_register');
    }

    public function showLawyer(){
        return view('pengacara_register');
    }

}
