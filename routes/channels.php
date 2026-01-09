<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('users', function ($user) {
    return true; // Public channel mostly, or authentication required but open to all logged in
});
