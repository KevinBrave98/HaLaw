<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TestController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/tes', function () {
    return view('coba');
});

Route::get('/footer', function () {
    return view('footer');
});

Route::get('/user_register', function () {
    return view('user_register');

});

Route::get('/daftar', function () {
    return view('daftar');
});


Route::get('/profil', [UserProfileController::class, 'show'])->name('profile.show');

Route::get('/profil/ubah', [UserProfileController::class, 'edit'])->name('profile.edit');

Route::get('/masuk', function () {
    return view('masuk');
});

Route::get('/footer', function () {
    return view('footer');
});

Route::get('/dashboard_pengguna_dan_pengacara_sebelum_login', function () {
    return view('dashboard_pengguna_dan_pengacara_sebelum_login');
});
Route::get('/pengacara_register', function () {
    return view('pengacara_register');
});

Route::get('/dashboard_user', function () {
    return view('dashboard_user');
});

Route::get('/navbar_user', function () {
    return view('navbar_user');
});
