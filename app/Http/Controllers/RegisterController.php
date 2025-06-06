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
        return view('user_register');
    }

    public function showLawyer(){
        return view('pengacara_register');
    }

    public function registerLawyer(Request $request){
        // $request->validate([
        //     'tanda_pengenal' => 'required|file|mimes:jpg,png,pdf|max:8192'
        // ]);

        // if($request->file('tanda_pengenal')->isValid()) {
            // }
            
            $validated = $request->validate([
            'nama_pengacara' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nik_pengacara' => 'required|unique:pengacaras|min:16|max:16',
            'nomor_telepon' => 'required|unique:pengacaras|min:11|max:12',
            'email' => 'required|email|unique:pengacaras',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $pengacara = Pengacara::create($validated);
        
        $path = $request->file('tanda_pengenal')->storeAs('tanda_pengenal');
        $pengacara->tanda_pengenal = $path;
        $pengacara->save();

        Auth::guard('lawyer')->login($pengacara);
        

        return redirect()->route('login.show');
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

        return redirect()->route('login.show');
    }
}
