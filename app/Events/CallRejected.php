<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallRejected implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $call_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($call_id)
    {
        $this->call_id = $call_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Broadcast on the same private channel the call uses
        return new PrivateChannel('callroom.' . $this->call_id);
    }

    /**
     * The name of the event to be broadcast.
     *
     * @return string
     */
    public function broadcastAs()
    {
        // This is the event name the client's JavaScript will listen for
        return 'call-rejected';
    }
}