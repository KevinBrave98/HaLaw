<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallEnded implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $callId;

    public function __construct($callId)
    {
        $this->callId = $callId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('callroom.' . $this->callId);
    }

    public function broadcastAs()
    {
        return 'call-ended';
    }
}
