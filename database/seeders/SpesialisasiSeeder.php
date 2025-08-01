<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SpesialisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('spesialisasis')->insert([
            [
                'nama_spesialisasi' => 'Hukum Perdata'
            ],
            [
                'nama_spesialisasi' => 'Hukum Pidana'
            ],
            [
                'nama_spesialisasi' => 'Hukum Keluarga'
            ],
            [
                'nama_spesialisasi' => 'Hukum Perusahaan'
            ],
            [
                'nama_spesialisasi' => 'Hukum Hak Kekayaan Intelektual'
            ],
            [
                'nama_spesialisasi' => 'Hukum Pajak'
            ],
            [
                'nama_spesialisasi' => 'Hukum Kepailitan'
            ],
            [
                'nama_spesialisasi' => 'Hukum Lingkungan Hidup'
            ],
            [
                'nama_spesialisasi' => 'Hukum Kepentingan Publik'
            ],
            [
                'nama_spesialisasi' => 'Hukum Ketenagakerjaan'
            ],
            [
                'nama_spesialisasi' => 'Hukum Tata Usaha Negara'
            ],
            [
                'nama_spesialisasi' => 'Hukum Imigrasi'
            ],
        ]);
    }
}
