<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PengacaraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik_pengacara' => $this->faker->unique()->numerify('################'), // 16 digit
            'nama_pengacara' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password123'), // default password
            'nomor_telepon' => $this->faker->unique()->phoneNumber,
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan', 'Memilih tidak menjawab']),
            'lokasi' => $this->faker->city,
            // 'spesialisasi' => $this->faker->randomElement(['Hukum Perdata', 'Hukum Pidana', 'Hukum Keluarga', 'Hukum Tata Negara']),
            'tarif_jasa' => $this->faker->numberBetween(500000, 2000000),
            'durasi_pengalaman' => $this->faker->numberBetween(1, 20),
            'pengalaman_bekerja' => $this->faker->company,
            'pendidikan' => $this->faker->randomElement(['S1 Hukum', 'S2 Hukum', 'S3 Hukum']),
            'chat' => true,
            'voice_chat' => $this->faker->boolean(80), // 80% kemungkinan true
            'video_call' => $this->faker->boolean(70),
            'status_konsultasi' => $this->faker->boolean(30), // 30% sedang aktif konsultasi
            'total_pendapatan' => $this->faker->randomFloat(2, 1000000, 100000000),
            'foto_pengacara' => null,
            'tanda_pengenal' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
