<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;
Broadcast::routes(['middleware' => ['web', 'auth:web,lawyer']]);

Broadcast::channel('chatroom.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id; // only allow the owner
});
