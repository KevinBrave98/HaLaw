<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Riwayat;
use App\Models\Pesan;
use App\Models\Pengguna;
use App\Models\Pengacara;
use App\Notifications\AutoCancelPengguna;
use App\Notifications\AutoCancelPengacara;

Artisan::command('batal:konsultasi-tanpa-respons', function () {
    $threshold = Carbon::now()->subMinutes(1); // ambil waktu 15 menit yang lalu

    $konsultasis = Riwayat::where('status', 'sedang berlangsung')
        ->where('created_at', '<=', $threshold)
        ->get();

    foreach ($konsultasis as $konsultasi) {
        // cek apakah ada pesan dari pengacara
        $adaBalasan = Pesan::where('id_riwayat', $konsultasi->id_riwayat)
            ->where('nik', $konsultasi->nik_pengacara)
            ->exists();

        if (!$adaBalasan) {
            $konsultasi->status = 'dibatalkan';
            $konsultasi->save();
            
            $konsultasi->load(['pengguna', 'pengacara']);
            
            $this->info("Konsultasi #{$konsultasi->id_riwayat} dibatalkan karena tidak ada respons.");

            // Ambil instance model
            $pengguna = Pengguna::find($konsultasi->nik_pengguna);
            $pengacara = Pengacara::find($konsultasi->nik_pengacara);

            // Kirim notifikasi ke pengguna
            if ($pengguna) {
                $pengguna->notify(new AutoCancelPengguna($konsultasi));
            }

            // Kirim notifikasi ke pengacara
            if ($pengacara) {
                $pengacara->notify(new AutoCancelPengacara($konsultasi));
            }
        }
    }
})->purpose('Membatalkan konsultasi yang tidak dijawab oleh pengacara dalam 15 menit');
