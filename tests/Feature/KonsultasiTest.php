<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\Riwayat;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KonsultasiTest extends TestCase
{
    use RefreshDatabase;

    protected Pengguna $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Buat dan loginkan satu pengguna untuk semua tes di file ini
        $this->user = Pengguna::factory()->create();
        $this->actingAs($this->user);
    }

    // =================================================================
    // TES UNTUK HALAMAN "SEDANG BERLANGSUNG"
    // =================================================================

    /** @test */
    public function it_shows_ongoing_and_waiting_consultations()
    {
        // Arrange: Buat 3 riwayat dengan status berbeda untuk user ini
        Riwayat::factory()->create(['nik_pengguna' => $this->user->nik_pengguna, 'status' => 'Sedang Berlangsung']);
        Riwayat::factory()->create(['nik_pengguna' => $this->user->nik_pengguna, 'status' => 'Menunggu Konfirmasi']);
        Riwayat::factory()->create(['nik_pengguna' => $this->user->nik_pengguna, 'status' => 'Selesai']); // Ini tidak boleh muncul

        // Act: Kunjungi halaman konsultasi sedang berlangsung
        $response = $this->get(route('konsultasi.berlangsung'));

        // Assert: Pastikan halaman berhasil dimuat dan menampilkan data yang benar
        $response->assertStatus(200);
        $response->assertViewIs('user.konsultasi_sedang_berlangsung');

        // Cek bahwa view menerima 2 data riwayat
        $response->assertViewHas('riwayats', function ($riwayats) {
            return $riwayats->count() === 2;
        });

        // Cek bahwa status 'Selesai' tidak ada di data yang dikirim
        $response->assertViewHas('riwayats', function ($riwayats) {
            return !$riwayats->contains('status', 'Selesai');
        });
    }

    /** @test */
    public function it_shows_empty_message_if_no_ongoing_consultations()
    {
        // Arrange: Buat 1 riwayat dengan status Selesai (tidak akan tampil)
        Riwayat::factory()->create(['nik_pengguna' => $this->user->nik_pengguna, 'status' => 'Selesai']);

        // Act: Kunjungi halaman
        $response = $this->get(route('konsultasi.berlangsung'));

        // Assert: Pastikan pesan "Tidak ada data" muncul
        $response->assertStatus(200);
        $response->assertSeeText('Tidak ada data untuk ditampilkan.');
    }

    // =================================================================
    // TES UNTUK HALAMAN "RIWAYAT KONSULTASI"
    // =================================================================

    /** @test */
    public function it_shows_completed_and_cancelled_consultation_history()
    {
        // Arrange: Buat 3 riwayat dengan status berbeda
        Riwayat::factory()->create(['nik_pengguna' => $this->user->nik_pengguna, 'status' => 'Selesai']);
        Riwayat::factory()->create(['nik_pengguna' => $this->user->nik_pengguna, 'status' => 'Dibatalkan']);
        Riwayat::factory()->create(['nik_pengguna' => $this->user->nik_pengguna, 'status' => 'Sedang Berlangsung']); // Ini tidak boleh muncul

        // Act: Kunjungi halaman riwayat
        $response = $this->get(route('riwayat.konsultasi'));

        // Assert: Pastikan hanya data Selesai dan Dibatalkan yang tampil
        $response->assertStatus(200);
        $response->assertViewIs('user.riwayat_konsultasi');
        $response->assertViewHas('riwayats', function ($riwayats) {
            return $riwayats->count() === 2;
        });
        $response->assertViewHas('riwayats', function ($riwayats) {
            return !$riwayats->contains('status', 'Sedang Berlangsung');
        });
    }

    /** @test */
    public function it_can_filter_history_by_status_selesai()
    {
        // Arrange: Buat 2 riwayat
        $selesai = Riwayat::factory()->create(['nik_pengguna' => $this->user->nik_pengguna, 'status' => 'Selesai']);
        $dibatalkan = Riwayat::factory()->create(['nik_pengguna' => $this->user->nik_pengguna, 'status' => 'Dibatalkan']);

        // Act: Kunjungi halaman dengan filter status=Selesai
        $response = $this->get(route('riwayat.konsultasi', ['status' => 'Selesai']));

        // Assert: Pastikan hanya riwayat Selesai yang tampil
        $response->assertStatus(200);
        $response->assertSeeText($selesai->pengacara->nama_pengacara);
        $response->assertDontSeeText($dibatalkan->pengacara->nama_pengacara);
    }

    /** @test */
    public function it_can_filter_history_by_date_range()
    {
        // Arrange: Buat 3 riwayat pada tanggal yang berbeda
        $kemarin = Riwayat::factory()->create([
            'nik_pengguna' => $this->user->nik_pengguna,
            'status' => 'Selesai',
            'created_at' => Carbon::yesterday()
        ]);
        $hari_ini = Riwayat::factory()->create([
            'nik_pengguna' => $this->user->nik_pengguna,
            'status' => 'Selesai',
            'created_at' => Carbon::now()
        ]);
        $bulan_lalu = Riwayat::factory()->create([
            'nik_pengguna' => $this->user->nik_pengguna,
            'status' => 'Selesai',
            'created_at' => Carbon::now()->subMonth()
        ]);

        // Act: Filter untuk data kemarin sampai hari ini
        $tanggal_awal = Carbon::yesterday()->toDateString();
        $tanggal_akhir = Carbon::now()->toDateString();

        $response = $this->get(route('riwayat.konsultasi', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]));

        // Assert: Pastikan hanya data kemarin dan hari ini yang tampil
        $response->assertStatus(200);
        $response->assertSeeText($kemarin->pengacara->nama_pengacara);
        $response->assertSeeText($hari_ini->pengacara->nama_pengacara);
        $response->assertDontSeeText($bulan_lalu->pengacara->nama_pengacara);
    }

    /** @test */
    public function unauthenticated_users_are_redirected()
    {
        auth()->logout(); // Logout user yang ada di setUp()

        $this->get(route('konsultasi.berlangsung'))->assertRedirect();
        $this->get(route('riwayat.konsultasi'))->assertRedirect();
    }
}
