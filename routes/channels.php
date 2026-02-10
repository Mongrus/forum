<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {

    [$a, $b] = explode('_', $chatId);

    return $user->id == $a || $user->id == $b;

});
