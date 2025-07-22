<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPaidConsultation implements ShouldBroadcast
{
    use SerializesModels;

    public $nama_pengguna;
    public $nik_pengacara;

    public function __construct($nama_pengguna, $nik_pengacara)
    {
        $this->nama_pengguna = $nama_pengguna;
        $this->nik_pengacara = $nik_pengacara;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('pengacara.' . $this->nik_pengacara);
    }

    public function broadcastAs()
    {
        return 'pembayaran.dikonfirmasi';
    }
}