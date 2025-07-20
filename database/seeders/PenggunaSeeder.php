<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        foreach (range(1, 10) as $index) {
            DB::table('penggunas')->insert([
                'nik_pengguna' => $faker->unique()->numerify('################'), // 16 digit
                'nama_pengguna' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'), // default password
                'nomor_telepon' => $faker->unique()->phoneNumber,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan', 'Memilih tidak menjawab']),
                'foto_pengguna' => null,
                'alamat' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
