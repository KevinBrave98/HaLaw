<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pengguna; // Asumsi model Pengguna ada di App\Models\Pengguna
use App\Models\Pengacara; // Asumsi model Lawyer ada di App\Models\Lawyer

class DashboardPageTest extends TestCase
{
    use RefreshDatabase; // Menggunakan trait ini untuk mereset database setelah setiap test

    /**
     * Test case untuk memastikan pengguna yang belum login (guest) dapat melihat halaman landing.
     *
     * @return void
     */
    public function test_guest_can_view_landing_page()
    {
        // 1. Lakukan request GET ke halaman utama ('/')
        $response = $this->get('/');

        // 2. Pastikan response sukses (HTTP status code 200)
        $response->assertStatus(200);

        // 3. Pastikan view yang ditampilkan adalah 'dashboard_sebelum_login'
        $response->assertViewIs('dashboard_sebelum_login');

        // 4. Pastikan halaman menampilkan teks-teks kunci
        $response->assertSee('We Fight<br>for Right', false); // 'false' agar tidak escape HTML
        $response->assertSee('Kami hadir untuk mendampingi setiap langkahmu mencari keadilan');
        $response->assertSee('Praktis');
        $response->assertSee('Terjangkau');
        $response->assertSee('Terpercaya');
        $response->assertSee('Apa Kata Mereka?');

        // 5. Pastikan tombol "Konsultasi Sekarang" ada dan mengarah ke /daftar
        $response->assertSee('<button class="banner-btn" onclick="window.location.href = \'/daftar\'">Konsultasi Sekarang</button>', false);

        // 6. Pastikan tombol "Telusuri Istilah Hukum" ada dan mengarah ke /kamus
        $response->assertSee('<button class="btn-kamus" onclick="window.location.href = \'/kamus\'">Telusuri Istilah Hukum</button>', false);
    }

    /**
     * Test case untuk memastikan pengguna biasa yang sudah login dialihkan ke dashboard user.
     *
     * @return void
     */
    public function test_authenticated_user_is_redirected_to_user_dashboard()
    {
        // Asumsi: Anda memiliki route dengan nama 'dashboard.user'
        // Route::get('/dashboard', function () { return 'Pengguna Dashboard'; })->name('dashboard.user');

        // 1. Buat satu user palsu menggunakan factory
        $user = Pengguna::factory()->create();

        // 2. Simulasikan user tersebut sedang login dan lakukan request GET ke halaman utama
        $response = $this->actingAs($user, 'web')->get('/');

        // 3. Pastikan response adalah redirect (HTTP status code 302) ke route 'dashboard.user'
        $response->assertRedirectToRoute('dashboard.user');
    }

    /**
     * Test case untuk memastikan pengacara yang sudah login dialihkan ke dashboard lawyer.
     *
     * @return void
     */
    public function test_authenticated_lawyer_is_redirected_to_lawyer_dashboard()
    {
        // Asumsi: Anda memiliki route dengan nama 'lawyer.dashboard'
        // Route::get('/lawyer/dashboard', function () { return 'Lawyer Dashboard'; })->name('lawyer.dashboard');

        // 1. Buat satu lawyer palsu menggunakan factory
        $lawyer = Pengacara::factory()->create();

        // 2. Simulasikan lawyer tersebut sedang login (menggunakan guard 'lawyer') dan lakukan request GET ke halaman utama
        $response = $this->actingAs($lawyer, 'lawyer')->get('/');

        // 3. Pastikan response adalah redirect (HTTP status code 302) ke route 'lawyer.dashboard'
        $response->assertRedirectToRoute('lawyer.dashboard');
    }
}
