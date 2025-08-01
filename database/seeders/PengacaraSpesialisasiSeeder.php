<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PengacaraSpesialisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengacara_spesialisasi')->insert([
            [
                'nik_pengacara' => '1234567812345678',
                'id_spesialisasi' => 1
            ],
            [
                'nik_pengacara' => '1234567812345678',
                'id_spesialisasi' => 2
            ],
            [
                'nik_pengacara' => '1234567812345678',
                'id_spesialisasi' => 3
            ],
        ]);
    }
}
