<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tes', function () {
    return view('coba');
});

Route::get('/footer', function () {
    return view('footer');
});

Route::get('/daftar/pengguna', [RegisterController::class, 'showUser'])->name('userregis.show');
Route::get('/daftar/pengacara', [RegisterController::class, 'showLawyer'])->name('lawyerregis.show');

// Route::get('/lawyer_register', function () {
//     return view('lawyer_register');

// });

Route::get('/daftar', function () {
    return view('daftar');
});


Route::get('/profil', [UserProfileController::class, 'show'])->name('profile.show');
Route::get('/profil/ubah', [UserProfileController::class, 'edit'])->name('profile.edit');

Route::get('/masuk', function () {
    return view('masuk');
});

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

Route::get('/navbar_user', function () {
    return view('navbar_user');
});
