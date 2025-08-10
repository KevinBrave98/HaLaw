<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Pengguna;
use App\Models\Pengacara;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatSeeder extends Seeder
{
    public function run()
    {
        $pengguna = Pengguna::where('nik_pengguna', '1234567812345678')->first();
        $pengacara1 = Pengacara::where('nik_pengacara', '1234567890123456')->first();
        $pengacara2 = Pengacara::where('nik_pengacara', '1234567890123457')->first();
        DB::table('riwayats')->insert([
            [
                'nik_pengguna' => $pengguna->nik_pengguna, // sesuaikan dengan nik pengguna yang ada
                'nik_pengacara' => $pengacara1->nik_pengacara,
                'status' => 'Selesai',
                'chat' => $pengacara1->chat,
                'voice_chat' => $pengacara1->voice_chat,
                'video_call' => $pengacara1->video_call,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'nik_pengguna' => $pengguna->nik_pengguna, // sesuaikan dengan nik pengguna yang ada
                'nik_pengacara' => $pengacara2->nik_pengacara,
                'status' => 'Dibatalkan',
                'chat' => $pengacara2->chat,
                'voice_chat' => $pengacara2->voice_chat,
                'video_call' => $pengacara2->video_call,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'nik_pengguna' => $pengguna->nik_pengguna, // sesuaikan dengan nik pengguna yang ada
                'nik_pengacara' => $pengacara2->nik_pengacara,
                'status' => 'Menunggu Konfirmasi',
                'chat' => $pengacara2->chat,
                'voice_chat' => $pengacara2->voice_chat,
                'video_call' => $pengacara2->video_call,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(2),
            ],
        ]);
    }
}
