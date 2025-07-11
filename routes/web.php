<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\LawyerProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\LawyerDashboardController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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
Route::get('/keluar_pengacara', [LawyerProfileController::class, 'exit'])->name('profile_pengacara.exit');

Route::get('/masuk', [LoginController::class, 'showLogin'])->name('login.show');

Route::get('/masuk/pengguna', [LoginController::class, 'showLoginUser'])->name('userLogin.show');
Route::get('/masuk/pengacara', [LoginController::class, 'showLoginLawyer'])->name('lawyerLogin.show');
Route::post('/masuk/pengguna', [LoginController::class, 'loginUser'])->name('userLogin.login');
Route::post('/masuk/pengacara', [LoginController::class, 'loginLawyer'])->name('lawyerLogin.login');

Route::get('/lupa-password/pengguna', [ForgotPasswordController::class, 'showUserLinkRequestForm'])->name('userPassword.request');
Route::post('/lupa-password/pengguna', [ForgotPasswordController::class, 'sendUserResetLinkEmail'])->name('userPassword.email');

Route::get('/lupa-password/pengacara', [ForgotPasswordController::class, 'showLawyerLinkRequestForm'])->name('lawyerPassword.request');
Route::post('/lupa-password/pengacara', [ForgotPasswordController::class, 'sendLawyerResetLinkEmail'])->name('lawyerPassword.email');

Route::get('/reset-password/pengguna/{token}', [ResetPasswordController::class, 'showUserResetForm'])->name('userPassword.reset');
Route::post('/reset-password/pengguna   ', [ResetPasswordController::class, 'userReset'])->name('userPassword.update');

Route::get('/reset-password/pengacara/{token}', [ResetPasswordController::class, 'showLawyerResetForm'])->name('lawyerPassword.reset');
Route::post('/reset-password/pengacara', [ResetPasswordController::class, 'lawyerReset'])->name('lawyerPassword.update');

Route::get('/', [DashboardController::class, 'dashboardView'])->name('dashboard.view');

Route::get('/profil_pengacara', [LawyerProfileController::class, 'show'])->name('lawyer.profile.show');
Route::get('/profil_pengacara/ubah', [LawyerProfileController::class, 'edit'])->name('lawyer.profile.edit');
Route::post('/profil_pengacara/ubah', [LawyerProfileController::class, 'update'])->name('lawyer.profile.update');
Route::get('/keluar', [LawyerProfileController::class, 'exit'])->name('lawyer.profile.exit');


Route::get('/dashboard_user/{nama_pengguna}', [UserDashboardController::class,'greetings']);
Route::get('/dashboard_user/{nama_pengguna}', [UserDashboardController::class,'greetings'])->name('dashboard.user');

Route::get(uri: '/dashboard_sebelum_login', action: [DashboardController::class, 'dashboardView'])->name('dashboard.sebelum_login');

Route::prefix('lawyer')->middleware(['auth:lawyer'])->group(function () {
    Route::get('/dashboard', [LawyerDashboardController::class, 'dashboard'])->name('lawyer.dashboard');
    Route::post('/dashboard/status-toggle', [LawyerDashboardController::class, 'toggleStatus'])->name('lawyer.status.toggle');
    Route::post('/dashboard/layanan', [LawyerDashboardController::class, 'updateLayanan'])->name('lawyer.layanan.update');
    Route::get('/profil_pengacara', [LawyerProfileController::class, 'show'])->name('lawyer.profile.show');
    Route::get('/profil_pengacara/ubah', [LawyerProfileController::class, 'edit'])->name('lawyer.profile.edit');
});

Route::post('/dashboard_user', [SearchController::class, 'search'])->name('dashboard.search.lawyer');
Route::get('/hasil_pencarian', [SearchController::class, 'view'])->name('search.pengacara.view');
