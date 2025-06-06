<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLogin(){
        $dynamic_login = [
            'form_action' => "",
            'selected_option' => "<option selected disabled hidden></option>
            <option value=\"masuk/pengguna\">Sebagai Pengguna</option>
            <option value=\"masuk/pengacara\">Sebagai Pengacara</option>"
        ];
        return view('masuk', ['dynamic_login' => $dynamic_login]);
    }

    public function showLoginLawyer(){
        $dynamic_login = [
            'form_action' => "route('lawyerLogin.login')", 
            'selected_option' => "<option disabled hidden></option>
            <option value=\"pengguna\">Sebagai Pengguna</option>
            <option selected value=\"pengacara\">Sebagai Pengacara</option>"
        ];
        return view('masuk', ['dynamic_login' => $dynamic_login]);
    }

    public function showLoginUser(){
        $dynamic_login = [
            'form_action' => route('userLogin.login'),
            'selected_option' => "<option disabled hidden></option>
            <option selected value=\"pengguna\">Sebagai Pengguna</option>
            <option value=\"pengacara\">Sebagai Pengacara</option>"
        ];
        return view('masuk', ['dynamic_login' => $dynamic_login]);
    }

    public function loginLawyer(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        Auth::attempt($validated);
    }

    public function loginUser(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($validated)){
            $request->session()->regenerate();
            return redirect()->route('dashboard.user');
        };

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah',
        ])->onlyInput('email');
    }
}
