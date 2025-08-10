<?php

namespace App\Console\Commands;

use App\Models\RiwayatDana;
use Illuminate\Console\Command;

class DetectFinishedConsultation extends Command
{
       /**
     * Nama dan signature untuk command Anda.
     */
    protected $signature = 'consultations:finished';

    /**
     * Deskripsi dari command.
     */
    protected $description = 'Mencari sesi konsultasi yang masanya sudah habis';

    /**
     * Logika utama dari command akan dieksekusi di sini.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan konsultasi yang masanya sudah habis...');

        $unresponsiveConsultations = Riwayat::where('status', 'Sedang Berlangsung')
            ->where('updated_at', '<=', Carbon::now()->subHour(1))
            ->get();

        if ($unresponsiveConsultations->isEmpty()) {
            $this->info('Belum ada konsultasi yang selesai.');
            return;
        }

        foreach ($unresponsiveConsultations as $consultation) {
            $consultation->status = 'Selesai';
            $consultation->save();

            $riwayat_dana = new RiwayatDana;
            $riwayat_dana->nik_pengacara = $consultation->pengacara->nik_pengacara;
            $riwayat_dana->tipe_riwayat_dana = 'Terima Pembayaran';
            $riwayat_dana->detail_riwayat_dana = $consultation->pengguna->nama_pengguna;
            $riwayat_dana->nominal = $consultation->nominal;
            $riwayat_dana->save();

            $this->info("Konsultasi ID: {$consultation->id} telah ditandai sebagai selesai.");
        }

        $this->info('Pengecekan selesai. ' . $unresponsiveConsultations->count() . ' konsultasi telah diperbarui.');
    }
}
