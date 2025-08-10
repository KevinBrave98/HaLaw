<?php

namespace Tests\Feature;

use App\Models\Pengacara;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginPengacaraTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pengacara_bisa_login_dengan_data_valid()
    {
        $pengacara = Pengacara::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/masuk/pengacara', [
            'email' => $pengacara->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('lawyer.dashboard'));
        $this->assertAuthenticatedAs($pengacara, 'lawyer');
    }

    /** @test */
    public function pengacara_gagal_login_jika_password_salah()
    {
        $pengacara = Pengacara::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->from('/masuk/pengacara')->post('/masuk/pengacara', [
            'email' => $pengacara->email,
            'password' => 'salahbanget',
        ]);

        $response->assertRedirect('/masuk/pengacara');
        $response->assertSessionHasErrors('email');
        $this->assertGuest('lawyer');
    }

    /** @test */
    public function pengacara_gagal_login_jika_field_kosong()
    {
        $response = $this->from('/masuk/pengacara')->post('/masuk/pengacara', []);

        $response->assertRedirect('/masuk/pengacara');
        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest('lawyer');
    }
}
