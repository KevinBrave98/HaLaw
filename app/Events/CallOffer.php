<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class CallOffer implements ShouldBroadcastNow
{
    use Dispatchable,InteractsWithSockets, SerializesModels;

    public $offer;
    public $callId;

    public function __construct($callId, $offer)
    {
        $this->callId = $callId;
        $this->offer = $offer;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('callroom.' . $this->callId);
    }

    public function broadcastAs()
    {
        return 'offer';
    }
     public function broadcastWith()
    {
        return [
            'offer' => $this->offer,
        ];
    }
}
