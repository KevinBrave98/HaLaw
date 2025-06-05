<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    public function showRegister() {
        return view('daftar');
    }

    public function showUser(){
        return view('user_register');
    }

    public function showLawyer(){
        return view('pengacara_register');
    }

    public function registerLawyer(Request $request){

    }

    public function registerUser(Request $request) {
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nik_pengguna' => 'required|unique:penggunas|min:16|max:16',
            'nomor_telepon' => 'required|unique:penggunas|min:11|max:12',
            'email' => 'required|email|unique:penggunas',
            'password' => 'required|min:8|confirmed'
        ]);

        $pengguna = Pengguna::create($validated);

        Auth::login($pengguna);

        return redirect()->route('masuk');
    }
}
