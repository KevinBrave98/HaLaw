<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KonsultasiDibatalkanNotification extends Notification
{
   use Queueable;

    protected $riwayat;

    public function __construct($riwayat)
    {
        $this->riwayat = $riwayat;
    }

    public function via($notifiable)
    {
        return ['database']; // atau 'mail', 'broadcast', dll
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Konsultasi dengan ID #' . $this->riwayat->id_riwayat . ' telah dibatalkan.',
            'status' => $this->riwayat->status,
        ];
    }
}
