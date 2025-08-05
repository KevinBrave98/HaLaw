<?php

namespace Database\Factories;

use App\Models\Riwayat;
use App\Models\Pengguna;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_riwayat' => Riwayat::factory(),
            'nik' => Pengguna::factory(),
            'teks' => "Hi"
        ];
    }
}
