<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    // Menampung user yang sedang login untuk digunakan di berbagai tes
    protected $user;

    // Method ini akan dijalankan sebelum setiap tes di dalam kelas ini
    protected function setUp(): void
    {
        parent::setUp();
        // Buat user dan login
        $this->user = Pengguna::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function unauthenticated_users_are_redirected_to_login()
    {
        auth()->logout(); // Pastikan tidak ada yang login

        $this->get(route('profile.show'))->assertRedirect(route('userLogin.show'));
        $this->get(route('profile.edit'))->assertRedirect(route('userLogin.show'));
        $this->post(route('profile.update'))->assertRedirect(route('userLogin.show'));
    }

    /** @test */
    public function it_displays_the_user_profile_page()
    {
        $this->get(route('profile.show'))
            ->assertStatus(200)
            ->assertViewIs('user.profil_pengguna')
            ->assertSeeText('Halo, ' . $this->user->nama_pengguna)
            ->assertSee($this->user->email)
            ->assertSee($this->user->nomor_telepon);
    }

    /** @test */
    public function it_displays_the_edit_user_profile_page()
    {
        $this->get(route('profile.edit'))
            ->assertStatus(200)
            ->assertViewIs('user.ubah_profil_pengguna')
            ->assertSee('value="' . $this->user->nama_pengguna . '"', false)
            ->assertSee('value="' . $this->user->email . '"', false);
    }

    /** @test */
    public function it_can_update_profile_with_valid_data()
    {
        $newData = [
            'nama_pengguna' => 'Nama Baru Pengguna',
            'nomor_telepon' => '081234567890',
            'email' => 'emailbaru@example.com',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jalan Baru No. 123',
        ];

        $this->post(route('profile.update'), $newData)->assertRedirect(route('profile.show'))->assertSessionHas('success', 'Profil berhasil diperbarui');

        // Pastikan database sudah terupdate
        $this->assertDatabaseHas('penggunas', [
            'nik_pengguna' => $this->user->nik_pengguna,
            'nama_pengguna' => 'Nama Baru Pengguna',
            'email' => 'emailbaru@example.com',
        ]);
    }
    /** @test */
    public function it_fails_validation_with_invalid_data()
    {
        $this->post(route('profile.update'), [
            'nama_pengguna' => '', // Nama kosong
            'email' => 'bukan-email', // Email tidak valid
        ])->assertSessionHasErrors(['nama_pengguna', 'email']);
    }

    /** @test */
    public function it_fails_validation_if_email_is_not_unique()
    {
        // Buat user lain dengan email yang akan kita gunakan
        $otherUser = Pengguna::factory()->create(['email' => 'sudahada@example.com']);

        // Coba update user saat ini dengan email milik user lain
        $this->post(route('profile.update'), [
            'nama_pengguna' => $this->user->nama_pengguna,
            'nomor_telepon' => $this->user->nomor_telepon,
            'email' => 'sudahada@example.com', // Email duplikat
            'jenis_kelamin' => $this->user->jenis_kelamin,
        ])->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_can_log_out_the_user()
    {
        $this->assertAuthenticatedAs($this->user);

        $this->get(route('profile.exit'))->assertRedirect(route('login.show'));

        $this->assertGuest(); // Pastikan user sudah tidak login
    }
}
