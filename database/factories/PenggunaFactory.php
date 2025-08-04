<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PenggunaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik_pengguna' => $this->faker->unique()->numerify('################'), // 16 digit
            'nama_pengguna' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password123'), // default password
            'nomor_telepon' => $this->faker->unique()->phoneNumber,
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan', 'Memilih tidak menjawab']),
            'foto_pengguna' => null,
            'alamat' => $this->faker->address,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
