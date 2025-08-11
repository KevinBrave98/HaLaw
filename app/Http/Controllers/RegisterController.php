<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Pengacara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    public function showRegister() {
        return view('daftar');
    }

    public function showUser(){
        return view('user.user_register');
    }

    public function showLawyer(){
        return view('lawyer.pengacara_register');
    }

    public function registerLawyer(Request $request){

            $validated = $request->validate([
            'nama_pengacara' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nik_pengacara' => 'required|unique:pengacaras|min:16|max:16',
            'nomor_telepon' => 'required|unique:pengacaras|min:11|max:12',
            'email' => 'required|email|unique:pengacaras',
            'password' => 'required|min:8|confirmed',
            'tanda_pengenal' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $pengacara = Pengacara::create($validated);

        $path = $request->file('tanda_pengenal')->storeAs('tanda_pengenal');
        $pengacara->tanda_pengenal = $path;
        $pengacara->save();

        // Auth::guard('lawyer')->login($pengacara);


        return redirect()->route('lawyerLogin.show');
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

        // Auth::login($pengguna);

        return redirect()->route('userLogin.show');
    }
}
