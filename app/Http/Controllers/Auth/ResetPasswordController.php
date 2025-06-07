<?php

namespace App\Http\Controllers\Auth;

use App\Models\Pengguna;
use App\Models\Pengacara;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function showUserResetForm(Request $request, $token)
    {
        return view('reset_sandi', [
            'token' => $token,
            'email' => $request->email,
            'reset_role' => route('userPassword.update')
        ]);
    }

    public function userReset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email|exists:penggunas,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Pengguna $user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login.show')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showLawyerResetForm(Request $request, $token)
    {
        return view('reset_sandi', [
            'token' => $token,
            'email' => $request->email,
            'reset_role' => route('lawyerPassword.update')
        ]);
    }

    public function lawyerReset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email|exists:pengacaras,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Pengacara $user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login.show')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
