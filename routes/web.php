<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserProfileController;

Route::get('/footer', function () {
    return view('footer');
});

Route::get('/daftar/pengguna', [RegisterController::class, 'showUser'])->name('userregis.show');
Route::get('/daftar/pengacara', [RegisterController::class, 'showLawyer'])->name('lawyerregis.show');
Route::post('/daftar/pengacara', [RegisterController::class, 'registerLawyer'])->name('lawyerregis.regis');

Route::get('/daftar', [RegisterController::class, 'showRegister'])->name('register.show');


Route::get('/profil', [UserProfileController::class, 'show'])->name('profile.show');
Route::get('/profil/ubah', [UserProfileController::class, 'edit'])->name('profile.edit');

Route::get('/masuk', [LoginController::class, 'showLogin'])->name('login.show');

Route::get('/masuk/pengguna', [LoginController::class, 'showLoginUser'])->name('userLogin.show');
Route::get('/masuk/pengacara', [LoginController::class, 'showLoginLawyer'])->name('lawyerLogin.show');
Route::post('/masuk/pengguna', [LoginController::class, 'loginLawyer'])->name('userLogin.login');
Route::post('/masuk/pengacara', [LoginController::class, 'loginUser'])->name('lawyerLogin.login');

Route::get('/dashboard_sebelum_login', function () {
    return view('dashboard_sebelum_login');
});

Route::get('/navbar_sebelum_login', function () {
    return view('navbar_sebelum_login');
});

Route::get('/footer', function () {
    return view('footer');
});

Route::get('/dashboard_sebelum_login', function () {
    return view('dashboard_sebelum_login');
});

Route::get('/dashboard_user', function () {
    return view('dashboard_user');
});