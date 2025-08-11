<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class CallAnswer implements ShouldBroadcastNow
{
    use Dispatchable,InteractsWithSockets, SerializesModels;

    public $answer;
    public $callId;

    public function __construct($callId, $answer)
    {
        $this->callId = $callId;
        $this->answer = $answer;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('callroom.' . $this->callId);
    }

    public function broadcastAs()
    {
        return 'answer';
    }
     public function broadcastWith()
    {
        return [
            'answer' => $this->answer,
        ];
    }
}
