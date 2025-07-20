<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PengacaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        foreach (range(1, 10) as $index) {
            DB::table('pengacaras')->insert([
                'nik_pengacara' => $faker->unique()->numerify('################'), // 16 digit
                'nama_pengacara' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('pengacara123'), // default password
                'nomor_telepon' => $faker->unique()->phoneNumber,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan', 'Memilih tidak menjawab']),
                'lokasi' => $faker->city,
                'spesialisasi' => $faker->randomElement(['Hukum Perdata', 'Hukum Pidana', 'Hukum Keluarga', 'Hukum Tata Negara']),
                'tarif_jasa' => $faker->numberBetween(500000, 2000000),
                'durasi_pengalaman' => $faker->numberBetween(1, 20),
                'pengalaman_bekerja' => $faker->company,
                'pendidikan' => $faker->randomElement(['S1 Hukum', 'S2 Hukum', 'S3 Hukum']),
                'chat' => true,
                'voice_chat' => $faker->boolean(80), // 80% kemungkinan true
                'video_call' => $faker->boolean(70),
                'status_konsultasi' => $faker->boolean(30), // 30% sedang aktif konsultasi
                'total_pendapatan' => $faker->randomFloat(2, 1000000, 100000000),
                'foto_pengacara' => null,
                'tanda_pengenal' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
