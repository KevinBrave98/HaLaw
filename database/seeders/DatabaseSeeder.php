<?php

namespace Database\Seeders;

use App\Models\Pengguna;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Pengguna::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',,
        ]);
        // $this->call(RiwayatSeeder::class);
    }
}
