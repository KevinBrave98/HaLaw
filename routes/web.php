<?php

use Illuminate\Support\Facades\Route;
use Tests\Feature\ConsultationRoomTest;
use App\Http\Controllers\CallController;
use App\Http\Controllers\KamusController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\LawyerProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\DetailPengacaraController;
use App\Http\Controllers\LawyerDashboardController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Routing\Route as RoutingRoute;

Route::get('/daftar/pengguna', [RegisterController::class, 'showUser'])->name('userregis.show');
Route::post('/daftar/pengguna', [RegisterController::class, 'registerUser'])->name('userregis');

Route::get('/daftar/pengacara', [RegisterController::class, 'showLawyer'])->name('lawyerregis.show');
Route::post('/daftar/pengacara', [RegisterController::class, 'registerLawyer'])->name('lawyerregis');

Route::get('/daftar', [RegisterController::class, 'showRegister'])->name('register.show');

Route::get('/kamus', [KamusController::class, 'index'])->name('kamus');
Route::middleware(['user.auth'])->group(function () {
    Route::get('/dashboard_user', [UserDashboardController::class,'greetings'])->name('dashboard.user');
    Route::get('/profil', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profil/ubah', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil/ubah', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/keluar', [UserProfileController::class, 'exit'])->name('profile.exit');
    Route::post('/dashboard_user', [SearchController::class, 'search'])->name('dashboard.search.lawyer');
    Route::get('/hasil_pencarian', [SearchController::class, 'view'])->name('search.pengacara.view');
    Route::post('/hasil_pencarian', [SearchController::class, 'search'])->name('search.pengacara.search');
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.pengacara');
    // Route::get('/pilih_pembayaran', [PembayaranController::class, 'pilih_payment'])->name('pilih_pembayaran.pengacara');
    // Route::get('/pembayaran/credit-card', function () {return view('user.pembayaran_card');});
    // Route::get('/pembayaran/qris', function () {return view('user.pembayaran_qris');});
    // Route::get('/pembayaran/bca', function () {return view('user.pembayaran_bca');});
    // Route::get('/pembayaran/mandiri', function () {return view('user.pembayaran_mandiri');});
    // Route::get('/pembayaran/blu', function () {return view('user.pembayaran_blu');});
    // Route::get('/pembayaran/gopay', function () {return view('user.pembayaran_gopay');});
    // Route::get('/pembayaran/ovo', function () {return view('user.pembayaran_ovo');});
    // Route::get('/pembayaran/spay', function () {return view('user.pembayaran_shopeepay');});
    // Route::post('/payment/confirm', [PembayaranController::class, 'confirm'])->name('payment.confirm');
    // Route::get('/konfirmasi-pembayaran', [PembayaranController::class, 'showConfirmation'])->name('payment.show_confirmation');
    Route::post('/payment/store-riwayat', [PembayaranController::class, 'storeRiwayat']);
    Route::get('/konsultasi/sedang-berlangsung', [KonsultasiController::class, 'konsultasiSedangBerlangsung'])->name('konsultasi.berlangsung');
    Route::get('/pilih_pembayaran', [PembayaranController::class, 'pilih_payment'])->name('pilih_pembayaran.pengacara');
    Route::get('/pembayaran/credit-card', function () {return view('user.pembayaran_card');});
    Route::get('/pembayaran/qris', function () {return view('user.pembayaran_qris');});
    Route::get('/pembayaran/bca', function () {return view('user.pembayaran_bca');});
    Route::get('/pembayaran/mandiri', function () {return view('user.pembayaran_mandiri');});
    Route::get('/pembayaran/blu', function () {return view('user.pembayaran_blu');});
    Route::get('/pembayaran/gopay', function () {return view('user.pembayaran_gopay');});
    Route::get('/pembayaran/ovo', function () {return view('user.pembayaran_ovo');});
    Route::get('/pembayaran/spay', function () {return view('user.pembayaran_shopeepay');});
    Route::post('/payment/confirm', [PembayaranController::class, 'confirm'])->name('payment.confirm');
    Route::get('/konfirmasi-pembayaran', [PembayaranController::class, 'showConfirmation'])->name('payment.show_confirmation');
    Route::get('/detail_pengacara/{nik}', [DetailPengacaraController::class, 'show'])->name('detail.pengacara');
    Route::get('/chatroom/{id}', [ConsultationController::class, 'index'])->name('consultation.client');
    Route::post('/chatroom/{id}/send', [ConsultationController::class, 'send'])->name('consultation.client.send');
    Route::get('/konsultasi/riwayat-konsultasi', [KonsultasiController::class, 'riwayatKonsultasi'])->name('riwayat.konsultasi');
});
//  Route::post('/chatroom/{id}/send', [ConsultationController::class, 'send'])->name('consultation.send');

Route::get('/keluar_pengacara', [LawyerProfileController::class, 'exit'])->name('profile_pengacara.exit');

Route::middleware(['guest.redirect'])->group(function () {
    Route::get('/masuk', [LoginController::class, 'showLogin'])->name('login.show');
    Route::get('/masuk/pengguna', [LoginController::class, 'showLoginUser'])->name('userLogin.show');
    Route::get('/masuk/pengacara', [LoginController::class, 'showLoginLawyer'])->name('lawyerLogin.show');
    Route::post('/masuk/pengguna', [LoginController::class, 'loginUser'])->name('userLogin.login');
    Route::post('/masuk/pengacara', [LoginController::class, 'loginLawyer'])->name('lawyerLogin.login');
});


Route::get('/lupa-password/pengguna', [ForgotPasswordController::class, 'showUserLinkRequestForm'])->name('userPassword.request');
Route::post('/lupa-password/pengguna', [ForgotPasswordController::class, 'sendUserResetLinkEmail'])->name('userPassword.email');

Route::get('/lupa-password/pengacara', [ForgotPasswordController::class, 'showLawyerLinkRequestForm'])->name('lawyerPassword.request');
Route::post('/lupa-password/pengacara', [ForgotPasswordController::class, 'sendLawyerResetLinkEmail'])->name('lawyerPassword.email');

Route::get('/reset-password/pengguna/{token}', [ResetPasswordController::class, 'showUserResetForm'])->name('userPassword.reset');
Route::post('/reset-password/pengguna   ', [ResetPasswordController::class, 'userReset'])->name('userPassword.update');

Route::get('/reset-password/pengacara/{token}', [ResetPasswordController::class, 'showLawyerResetForm'])->name('lawyerPassword.reset');
Route::post('/reset-password/pengacara', [ResetPasswordController::class, 'lawyerReset'])->name('lawyerPassword.update');

Route::get('/', [DashboardController::class, 'dashboardView'])->name('dashboard.view');

// Route::get(uri: '/dashboard_sebelum_login', action: [DashboardController::class, 'dashboardView'])->name('dashboard.sebelum_login');

Route::prefix('lawyer')->middleware(['lawyer.auth'])->group(function () {
    Route::get('/dashboard', [LawyerDashboardController::class, 'dashboard'])->name('lawyer.dashboard');
    Route::post('/dashboard/status-toggle', [LawyerDashboardController::class, 'toggleStatus'])->name('lawyer.status.toggle');
    Route::post('/dashboard/layanan', [LawyerDashboardController::class, 'updateLayanan'])->name('lawyer.layanan.update');
    Route::get('/profil_pengacara', [LawyerProfileController::class, 'show'])->name('lawyer.profile.show');
    Route::get('/profil_pengacara/ubah', [LawyerProfileController::class, 'edit'])->name('lawyer.profile.edit');
    Route::post('/profil_pengacara/ubah', [LawyerProfileController::class, 'update'])->name('lawyer.profile.update');
    Route::get('/keluar', [LawyerProfileController::class, 'exit'])->name('lawyer.profile.exit');
    Route::get('/penarikan_pendapatan',[PenarikanController::class,'dashboard'])->name('lawyer.penarikan.pendapatan');
    Route::get('/detail_penarikan', [PenarikanController::class,'detail'])->name('lawyer.detail_penarikan');
    Route::get('/ubah_rekening', [PenarikanController::class, 'viewUpdate'])->name('lawyer.ubah.rekening');
    Route::post('/ubah_rekening', [PenarikanController::class, 'updateRekening']);
    Route::post('/detail_penarikan', [PenarikanController::class, 'tarikDana'])->middleware('auth:lawyer')->name('pengacara.tarikDana');
    Route::get('/hasil_penarikan', [PenarikanController::class, 'hasilpenarikan'])->name('lawyer.hasil.penarikan');
    Route::get('/penarikan_gagal', [PenarikanController::class, 'gagal'])->name('lawyer.penarikan_gagal');
    Route::get('/konsultasi/sedang-berlangsung', [KonsultasiController::class, 'konsultasiSedangBerlangsungPengacara'])->name('lawyer.konsultasi.berlangsung');
    Route::get('/chatroom/{id}', [ConsultationController::class, 'index'])->name('consultation.lawyer');
    Route::post('/chatroom/{id}/send', [ConsultationController::class, 'send'])->name('consultation.lawyer.send');
    Route::get('/notifikasi-konsultasi', [NotifikasiController::class, 'cekNotifikasi']);
    Route::post('/konsultasi/{id}/konfirmasi', [NotifikasiController::class, 'konfirmasi']);
    Route::post('/konsultasi/{id}/batalkan', [NotifikasiController::class, 'batalkan']);
});
Route::post('/delete-notification/{id}', [NotifikasiController::class, 'hapus'])->name('notifikasi.hapus');
Route::post('/delete-notification-pengacara/{id}', [NotifikasiController::class, 'hapusnotifpengacara']);

//  Route::post('/lawyer/chatroom/{id}/send', [ConsultationController::class, 'send'])->name('consultation.send');
// routes/web.php
Route::post('/call/offer', [CallController::class, 'sendOffer']);
Route::post('/call/answer', [CallController::class, 'sendAnswer']);
Route::post('/call/ice', [CallController::class, 'sendIce']);
Route::post('/call/end', [CallController::class, 'endCall']);



