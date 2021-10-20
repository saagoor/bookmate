<?php

use App\Models\Conversation;
use App\Models\Discussion;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat.{conversation}', function ($user, Conversation $conversation) {
    return (int)$user->id === (int)$conversation->user_one_id || (int)$user->id === (int)$conversation->user_two_id;
});

Broadcast::channel('discussion.{discussion}', function ($user, Discussion $discussion) {
    return true;
});
