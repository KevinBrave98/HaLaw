<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginPenggunaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pengguna_bisa_login_dengan_data_valid()
    {
        $pengguna = Pengguna::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/masuk/pengguna', [
            'email' => $pengguna->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard.user'));
        $this->assertAuthenticatedAs($pengguna);
    }

    /** @test */
    public function pengguna_gagal_login_jika_password_salah()
    {
        $pengguna = Pengguna::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->from('/masuk/pengguna')->post('/masuk/pengguna', [
            'email' => $pengguna->email,
            'password' => 'salahbanget',
        ]);

        $response->assertRedirect('/masuk/pengguna');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function pengguna_gagal_login_jika_field_kosong()
    {
        $response = $this->from('/masuk/pengguna')->post('/masuk/pengguna', []);

        $response->assertRedirect('/masuk/pengguna');
        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }
}
