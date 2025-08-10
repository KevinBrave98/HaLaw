<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pastikan guest bisa melihat halaman daftar
     */
    public function test_guest_can_view_register_page()
    {
        // 1. Lakukan GET ke /daftar
        $response = $this->get('/daftar');

        // 2. Pastikan status 200
        $response->assertStatus(200);

        // 3. Pastikan view yang digunakan adalah 'daftar'
        $response->assertViewIs('daftar');

        // 4. Pastikan teks penting muncul
        $response->assertSee('Selamat Datang Di HaLaw');
        $response->assertSee('Daftar sebagai...');
        $response->assertSee('Pengguna');
        $response->assertSee('Pengacara');

        // 5. Pastikan tautan ke halaman register pengguna dan pengacara ada
        $response->assertSee(route('userregis.show'), false);
        $response->assertSee(route('lawyerregis.show'), false);
    }

    /**
     * Pastikan link "Daftar sebagai Pengguna" mengarah ke halaman user register
     */
    public function test_guest_can_access_user_register_page()
    {
        $response = $this->get(route('userregis.show'));

        $response->assertStatus(200);
        $response->assertViewIs('user.user_register');
    }

    /**
     * Pastikan link "Daftar sebagai Pengacara" mengarah ke halaman lawyer register
     */
    public function test_guest_can_access_lawyer_register_page()
    {
        $response = $this->get(route('lawyerregis.show'));

        $response->assertStatus(200);
        $response->assertViewIs('lawyer.pengacara_register');
    }
}
