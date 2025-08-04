<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AutoCancelPengguna extends Notification
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
            'message' => 'Konsultasi Anda dengan Pengacara ' . $this->riwayat->pengacara->nama_pengacara . ' dibatalkan otomatis karena tidak ada respons selama 15 menit.',
            'status' => $this->riwayat->status,
        ];
    }
}
