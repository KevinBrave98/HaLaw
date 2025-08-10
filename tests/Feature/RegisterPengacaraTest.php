<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Pengacara;


class RegisterPengacaraTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function semua_field_wajib_diisi()
    {
        $response = $this->post(route('lawyerregis'), []);

        $response->assertSessionHasErrors([
            'nama_pengacara',
            'nik_pengacara',
            'nomor_telepon',
            'email',
            'password',
            'tanda_pengenal'
        ]);
    }

    /** @test */
    public function nik_harus_16_digit()
    {
        $response = $this->post(route('lawyerregis'), [
            'nama_pengacara' => 'Test',
            'nik_pengacara' => '12345',
            'nomor_telepon' => '081234567890',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'tanda_pengenal' => UploadedFile::fake()->image('ktp.jpg')
        ]);

        $response->assertSessionHasErrors('nik_pengacara');
    }

    /** @test */
    public function nomor_telepon_harus_11_sampai_12_digit()
    {
        $response = $this->post(route('lawyerregis'), [
            'nama_pengacara' => 'Test',
            'nik_pengacara' => '1234567890123456',
            'nomor_telepon' => '08123', // terlalu pendek
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'tanda_pengenal' => UploadedFile::fake()->image('ktp.jpg')
        ]);

        $response->assertSessionHasErrors('nomor_telepon');
    }

    /** @test */
    public function email_harus_format_benar()
    {
        $response = $this->post(route('lawyerregis'), [
            'nama_pengacara' => 'Test',
            'nik_pengacara' => '1234567890123456',
            'nomor_telepon' => '081234567890',
            'email' => 'bukan-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'tanda_pengenal' => UploadedFile::fake()->image('ktp.jpg')
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function password_harus_minimal_8_karakter_dan_terkonfirmasi()
    {
        $response = $this->post(route('lawyerregis'), [
            'nama_pengacara' => 'Test',
            'nik_pengacara' => '1234567890123456',
            'nomor_telepon' => '081234567890',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'beda',
            'tanda_pengenal' => UploadedFile::fake()->image('ktp.jpg')
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function tanda_pengenal_harus_diupload()
    {
        $response = $this->post(route('lawyerregis'), [
            'nama_pengacara' => 'Test',
            'nik_pengacara' => '1234567890123456',
            'nomor_telepon' => '081234567890',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            // tidak ada tanda_pengenal
        ]);

        $response->assertSessionHasErrors('tanda_pengenal');
    }

    /** @test */
    public function bisa_registrasi_pengacara_dengan_data_valid()
    {
        Storage::fake('public');

        $response = $this->post(route('lawyerregis'), [
            'nama_pengacara' => 'Test Pengacara',
            'nik_pengacara' => '1234567890123456',
            'nomor_telepon' => '081234567890',
            'email' => 'pengacara@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'tanda_pengenal' => UploadedFile::fake()->image('ktp.jpg')
        ]);

        $response->assertRedirect(); // Redirect ke halaman setelah sukses

        $this->assertDatabaseHas('pengacaras', [
            'nama_pengacara' => 'Test Pengacara',
            'nik_pengacara' => '1234567890123456',
            'nomor_telepon' => '081234567890',
            'email' => 'pengacara@test.com',
        ]);

        $pengacara = Pengacara::where('email', 'pengacara@test.com')->first();
        $this->assertTrue(Hash::check('password123', $pengacara->password));
    }
}
