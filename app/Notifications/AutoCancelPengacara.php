<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AutoCancelPengacara extends Notification
{
    use Queueable;

    protected $riwayat;

    public function __construct($riwayat)
    {
        $this->riwayat = $riwayat;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Sistem membatalkan konsultasi dengan pengguna ' . $this->riwayat->pengguna->nama_pengguna . ' karena tidak ada respons Anda selama 15 menit.',
            'status' => $this->riwayat->status,
        ];
    }
}
