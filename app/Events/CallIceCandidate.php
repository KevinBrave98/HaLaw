<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class CallIceCandidate implements ShouldBroadcastNow
{
    use Dispatchable,InteractsWithSockets, SerializesModels;

    public $candidate;
    public $callId;

    public function __construct($callId, $candidate)
    {
        $this->callId = $callId;
        $this->candidate = $candidate;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('callroom.' . $this->callId);
    }

    public function broadcastAs()
    {
        return 'candidate';
    }
     public function broadcastWith()
    {
        return [
            'candidate' => $this->candidate,
        ];
    }
}
