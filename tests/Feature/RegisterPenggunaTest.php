<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Pengguna;

class RegisterPenggunaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pengguna_dapat_register_dengan_data_valid()
    {
        $response = $this->post(route('userregis'), [
            'nama_pengguna' => 'Kevin Brave',
            'nik_pengguna' => '1234567890123456',
            // 'alamat' => 'Jl. Mawar No. 123',
            'nomor_telepon' => '081234567890',
            'email' => 'kevin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(); // Redirect ke halaman setelah register
        $this->assertDatabaseHas('penggunas', [
            'nama_pengguna' => 'Kevin Brave',
            'email' => 'kevin@example.com',
        ]);
    }

    /** @test */
    public function register_gagal_jika_ada_field_wajib_kosong()
    {
        $response = $this->from(route('userregis'))
            ->post(route('userregis'), [
                'nama_pengguna' => '',
                'nik_pengguna' => '',
                'alamat' => '',
                'nomor_telepon' => '',
                // 'email' => '',
                'password' => '',
                'password_confirmation' => '',
            ]);

        $response->assertRedirect(route('userregis'));
        $response->assertSessionHasErrors([
            'nama_pengguna', 'nik_pengguna',
            'nomor_telepon', 'email', 'password'
        ]);
    }

    /** @test */
    public function register_gagal_jika_email_sudah_terpakai()
    {
        Pengguna::factory()->create([
            'email' => 'kevin@example.com',
        ]);

        $response = $this->from(route('userregis'))
            ->post(route('userregis'), [
                'nama_pengguna' => 'Kevin Brave',
                'nik_pengguna' => '1234567890123456',
                // 'alamat' => 'Jl. Mawar No. 123',
                'nomor_telepon' => '081234567890',
                'email' => 'kevin@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

        $response->assertRedirect(route('userregis'));
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function register_gagal_jika_password_konfirmasi_tidak_sama()
    {
        $response = $this->from(route('userregis'))
            ->post(route('userregis'), [
                'nama_pengguna' => 'Kevin Brave',
                'nik_pengguna' => '1234567890123456',
                'alamat' => 'Jl. Mawar No. 123',
                'nomor_telepon' => '081234567890',
                'email' => 'kevin@example.com',
                'password' => 'password123',
                'password_confirmation' => 'salahpassword',
            ]);

        $response->assertRedirect(route('userregis'));
        $response->assertSessionHasErrors(['password']);
    }
}
