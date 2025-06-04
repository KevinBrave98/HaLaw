<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/lawyer_register', function () {
    return view('lawyer_register');

});

Route::get('/daftar', function () {
    return view('daftar');
});

Route::get('/profilpengguna', function () {
    return view('profil_pengguna');
});

Route::get('/ubahprofilpengguna', function () {
    return view('ubah_profil_pengguna');
});

Route::get('/masuk', function () {
    return view('masuk');
});

Route::get('/dashboard_sebelum_login', function () {
    return view('dashboard_sebelum_login');
});

Route::get('/navbar_sebelum_login', function () {
    return view('navbar_sebelum_login');
});