<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\LawyerDashboardController;

Route::get('/footer', function () {
    return view('footer');
});

Route::get('/daftar/pengguna', [RegisterController::class, 'showUser'])->name('userregis.show');
Route::post('/daftar/pengguna', [RegisterController::class, 'registerUser'])->name('userregis');


Route::get('/daftar/pengacara', [RegisterController::class, 'showLawyer'])->name('lawyerregis.show');
Route::post('/daftar/pengacara', [RegisterController::class, 'registerLawyer'])->name('lawyerregis');

Route::get('/daftar', [RegisterController::class, 'showRegister'])->name('register.show');


Route::middleware('auth')->group(function () {
    Route::get('/profil', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profil/ubah', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil/ubah', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/keluar', [UserProfileController::class, 'exit'])->name('profile.exit');
});

Route::get('/masuk', [LoginController::class, 'showLogin'])->name('login.show');

Route::get('/masuk/pengguna', [LoginController::class, 'showLoginUser'])->name('userLogin.show');
Route::get('/masuk/pengacara', [LoginController::class, 'showLoginLawyer'])->name('lawyerLogin.show');
Route::post('/masuk/pengguna', [LoginController::class, 'loginUser'])->name('userLogin.login');
Route::post('/masuk/pengacara', [LoginController::class, 'loginLawyer'])->name('lawyerLogin.login');

Route::get('/lupa-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/navbar_sebelum_login', function () {
    return view('navbar_sebelum_login');
});

Route::get('/footer', function () {
    return view('footer');
});


Route::get('/dashboard_user', function () {
    return view('dashboard_user');
})->name('dashboard.user');

Route::get('/reset-demo', function () {
    return view('reset_sandi', [
        'token' => 'dummy-token',
        'email' => 'dummy@example.com'
    ]);
});

Route::get('/test', function() {
    return view('test');
});

Route::get('/dasbor_pengacara', function () {
    return view('lawyer.dashboard');
});

Route::get('/dasbor_pengacara/{nama_pengacara}', [LawyerDashboardController::class, 'dashboard']);

Route::post('/dasbor_pengacara/status-toggle', [LawyerDashboardController::class, 'toggleStatus'])->name('dasbor_pengacara.toggleStatus');

Route::post('/dasbor_pengacara/layanan', [LawyerDashboardController::class, 'updateLayanan'])->name('dasbor_pengacara.updateLayanan');