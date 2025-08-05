<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Pengguna;
use App\Models\Pengacara;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiwayatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik_pengguna' => Pengguna::factory(),
            'nik_pengacara' => Pengacara::factory(),
            'status' => 'Menunggu Konfirmasi',
            'created_at' => Carbon::now()->subDays(3),
            'updated_at' => Carbon::now()->subDays(2),
        ];
    }
}
