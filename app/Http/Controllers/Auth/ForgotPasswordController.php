<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{
    public function showUserLinkRequestForm()
    {
        return view('lupa_sandi', ['reset_password' => route('userPassword.email')]); // tampilan input email
    }

    public function sendUserResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:penggunas,email'
        ]);

        $status = Password::broker('users')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showLawyerLinkRequestForm()
    {
        return view('lupa_sandi', ['reset_password' => route('lawyerPassword.email')]); // tampilan input email
    }

    public function sendLawyerResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:pengacaras,email'
        ]);

        $status = Password::broker('lawyers')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
