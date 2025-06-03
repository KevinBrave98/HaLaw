<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tes', function () {
    return view('coba');
});

Route::get('/user_register', function () {
    return view('user_register');
Route::get('/daftar', function () {
    return view('daftar');
});

Route::get('/profilpengguna', function () {
    return view('profil_pengguna');
});

Route::get('/ubahprofilpengguna', function () {
    return view('ubah_profil_pengguna');
});
