<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pengacara;
use App\Models\Riwayat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class LawyerDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_lawyer_dashboard_with_correct_data()
    {
        $pengacara = Pengacara::factory()->create([
            'email' => 'lawyer@example.com',
            'status_konsultasi' => 1,
            'total_pendapatan' => 250000,
            'nik_pengacara' => '1234123412341234'
        ]);

        // Buat riwayat dengan penilaian
        Riwayat::factory()->create([
            'nik_pengacara' => '1234123412341234',
            'penilaian' => 4
        ]);
        Riwayat::factory()->create([
            'nik_pengacara' => '1234123412341234',
            'penilaian' => 5
        ]);

        $this->actingAs($pengacara, 'lawyer');

        $response = $this->get(route('lawyer.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('pengacara', function ($data) use ($pengacara) {
            return $data->nik_pengacara === $pengacara->nik_pengacara;
        });
        $response->assertViewHas('status_konsultasi', 1);
        $response->assertViewHas('totalPendapatan', 250000);
        $response->assertViewHas('penilaian', 4.5);

        // Pastikan nama pengacara terlihat di halaman
        $response->assertSee("Halo, <strong>{$pengacara->nama_pengacara}</strong>!", false);
    }

    /** @test */
    public function it_can_toggle_lawyer_status()
    {
        $pengacara = Pengacara::factory()->create([
            'email' => 'lawyer@example.com',
            'status_konsultasi' => 1
        ]);

        $this->actingAs($pengacara, 'lawyer');

        $response = $this->post(route('lawyer.status.toggle'));

        $response->assertRedirect();
        $this->assertDatabaseHas('pengacaras', [
            'nik_pengacara' => $pengacara->nik_pengacara,
            'status_konsultasi' => 0
        ]);
    }

    /** @test */
    public function it_can_update_layanan()
    {
        $pengacara = Pengacara::factory()->create([
            'email' => 'lawyer@example.com',
            'chat' => 0,
            'voice_chat' => 0,
            'video_call' => 0
        ]);

        $this->actingAs($pengacara, 'lawyer');

        $response = $this->post(route('lawyer.layanan.update'), [
            'chat' => 'on',
            'voice_chat' => 'on'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pengacaras', [
            'nik_pengacara' => $pengacara->nik_pengacara,
            'chat' => 1,
            'voice_chat' => 1,
            'video_call' => 0
        ]);
    }
}
