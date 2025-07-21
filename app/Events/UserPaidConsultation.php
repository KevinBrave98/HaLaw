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
    use InteractsWithSockets;

    public $user;
    public $nik_pengacara;

    public function __construct($user, $nik_pengacara)
    {
        $this->user = $user;
        $this->nik_pengacara = $nik_pengacara;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('pengacara.' . $this->nik_pengacara);
    }
}