<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Riwayat;
use App\Models\RiwayatDana;
use Illuminate\Console\Command;
use App\Models\RiwayatKonsultasi; // Ganti dengan namespace model Anda

class UpdateExpiredConsultations extends Command
{
    /**
     * Nama dan signature untuk command Anda.
     */
    protected $signature = 'consultations:update-expired';

    /**
     * Deskripsi dari command.
     */
    protected $description = 'Mencari sesi konsultasi yang aktif dan mengubah statusnya menjadi "selesai" jika waktu sudah habis';

    /**
     * Logika utama dari command akan dieksekusi di sini.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan konsultasi yang kedaluwarsa...');

        // 1. Cari semua sesi yang statusnya 'berlangsung' DAN
        //    waktu mulainya sudah lebih dari 1 jam yang lalu.
        $expiredConsultations = Riwayat::where('status', 'Sedang Berlangsung')
            ->where('updated_at', '<=', Carbon::now()->subHour())
            ->get();

        if ($expiredConsultations->isEmpty()) {
            $this->info('Tidak ada konsultasi yang kedaluwarsa ditemukan.');
            return;
        }

        // 2. Loop setiap sesi yang kedaluwarsa dan ubah statusnya
        foreach ($expiredConsultations as $consultation) {
            $consultation->status = 'Selesai'; // Ganti 'selesai' sesuai dengan nilai di tabel Anda
            $consultation->save();

            $riwayat_dana = new RiwayatDana;
            $riwayat_dana->nik_pengacara = $consultation->pengacara->nik_pengacara;
            $riwayat_dana->tipe_riwayat_dana = 'Terima Pembayaran';
            $riwayat_dana->detail_riwayat_dana = $consultation->pengguna->nama_pengguna;
            $riwayat_dana->nominal = $consultation->nominal;
            $riwayat_dana->save();
            $this->info("Konsultasi ID: {$consultation->id} telah ditandai sebagai selesai.");
        }

        $this->info('Pengecekan selesai. ' . $expiredConsultations->count() . ' konsultasi telah diperbarui.');
    }
}
