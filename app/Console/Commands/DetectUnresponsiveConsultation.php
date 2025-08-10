<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Riwayat;
use Illuminate\Console\Command;
use App\Models\RiwayatKonsultasi; // Ganti dengan namespace model Anda

class DetectUnresponsiveConsultation extends Command
{
    /**
     * Nama dan signature untuk command Anda.
     */
    protected $signature = 'consultations:unresponsive';

    /**
     * Deskripsi dari command.
     */
    protected $description = 'Mencari sesi konsultasi yang tidak responsif dan mengubah statusnya menjadi "dibatalkan" jika waktu sudah habis';

    /**
     * Logika utama dari command akan dieksekusi di sini.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan konsultasi yang kedaluwarsa...');

        // 1. Cari semua sesi yang statusnya 'berlangsung' DAN
        //    waktu mulainya sudah lebih dari 1 jam yang lalu.
        $unresponsiveConsultations = Riwayat::where('status', 'Menunggu Konfirmasi')
            ->where('updated_at', '<=', Carbon::now()->subMinutes(10))
            ->get();

        if ($unresponsiveConsultations->isEmpty()) {
            $this->info('Tidak ada konsultasi yang tidak responsif.');
            return;
        }

        // 2. Loop setiap sesi yang kedaluwarsa dan ubah statusnya
        foreach ($unresponsiveConsultations as $consultation) {
            $consultation->status = 'Dibatalkan'; // Ganti 'selesai' sesuai dengan nilai di tabel Anda
            $consultation->save();
            $pengacara = $consultation->pengacara;
            $pengacara->status_konsultasi = 0;
            $pengacara->save();
            $this->info("Konsultasi ID: {$consultation->id} telah ditandai sebagai selesai.");
        }

        $this->info('Pengecekan selesai. ' . $unresponsiveConsultations->count() . ' konsultasi telah diperbarui.');
    }
}