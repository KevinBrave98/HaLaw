<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLogin(){
        // $dynamic_login = [
        //     'form_action' => "",
        //     'selected_option' => "<option selected disabled hidden></option>
        //     <option value='userLogin.show'>Sebagai Pengguna</option>
        //     <option value='lawyerLogin.show'>Sebagai Pengacara</option>",
        //     "forgot_password" => route('userPassword.request')
        // ];
        // return view('masuk', ['dynamic_login' => $dynamic_login]);
        return redirect()->route('userLogin.show');
    }

    public function showLoginLawyer(){
        $dynamic_login = [
            'form_action' => route('lawyerLogin.login'),
            'selected_option' => "<option disabled hidden></option>
            <option value='userLogin.show'>Sebagai Pengguna</option>
            <option selected value='lawyerLogin.show'>Sebagai Pengacara</option>",
            'forgot_password' => route('lawyerPassword.request')
        ];
        return view('masuk', ['dynamic_login' => $dynamic_login]);
    }

    public function showLoginUser(){
        $dynamic_login = [
            'form_action' => route('userLogin.login'),
            'selected_option' => "<option disabled hidden></option>
            <option selected value='userLogin.show'>Sebagai Pengguna</option>
            <option value='lawyerLogin.show'>Sebagai Pengacara</option>",
            "forgot_password" => route('userPassword.request')
        ];
        return view('masuk', ['dynamic_login' => $dynamic_login]);
    }

    public function loginLawyer(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

         if(Auth::guard('lawyer')->attempt($validated)){
            $request->session()->regenerate();
            return redirect()->route('dashboard.view');
        };

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah',
        ])->onlyInput('email');
    }

    public function loginUser(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($validated)){
            $request->session()->regenerate();
            return redirect()->route('dashboard.view');
        };

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah',
        ])->onlyInput('email');
    }

    public function showForgotPassword()
    {
        return view('lupa_sandi');
    }
}
