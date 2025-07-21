<?php

namespace App\Observers;

use App\Models\Riwayat;
use App\Notifications\NotifPengacara;
use Illuminate\Support\Facades\Notification;
use App\Notifications\KonsultasiDibatalkanNotification;

class RiwayatObserver
{
    /**
     * Handle the Riwayat "created" event.
     */
    public function created(Riwayat $riwayat): void
    {
        //
    }

    /**
     * Handle the Riwayat "updated" event.
     */
    public function updating(Riwayat $riwayat): void
    {
        if ($riwayat->isDirty('status') && $riwayat->status === 'dibatalkan') {
            // Misal: kirim ke user dan pengacara berdasarkan NIK
            $nikPengguna = $riwayat->nik_pengguna;
            $nikPengacara = $riwayat->nik_pengacara;

            // Ambil user dari NIK
            $pengguna = \App\Models\Pengguna::where('nik_pengguna', $nikPengguna)->first();
            $pengacara = \App\Models\Pengacara::where('nik_pengacara', $nikPengacara)->first();

            if ($pengguna) {
                Notification::send($pengguna, new KonsultasiDibatalkanNotification($riwayat));
            }

            if ($pengacara) {
                Notification::send($pengacara, new NotifPengacara($riwayat));
            }
        }
    }

    /**
     * Handle the Riwayat "deleted" event.
     */
    public function deleted(Riwayat $riwayat): void
    {
        //
    }

    /**
     * Handle the Riwayat "restored" event.
     */
    public function restored(Riwayat $riwayat): void
    {
        //
    }

    /**
     * Handle the Riwayat "force deleted" event.
     */
    public function forceDeleted(Riwayat $riwayat): void
    {
        //
    }
}
