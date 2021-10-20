<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{

    public function conversations()
    {
        $conversations = auth()->user()->conversations()->paginate(10);
        $conversations->loadCount(['messages as unread_messages_count' => function ($query) {
            $query
                ->where('sender_id', '!=', auth()->user()->id)
                ->whereNull('seen_at');
        }]);
        return $conversations;
    }

    public function showConversation(User $user)
    {
        return Conversation::matchConversation($user, auth()->user());
    }

    public function messages(User $user)
    {
        $conversation = Conversation::matchConversation($user, auth()->user());
        if (!$conversation) {
            return response('No conversation yet with this user.', 404);
        }
        return $conversation->messages()->paginate(50);
    }

    public function seeMessages(User $user)
    {
        $conversation = Conversation::matchConversation($user, auth()->user());
        if (!$conversation) {
            return response('No conversation yet with this user.', 404);
        }
        $conversation
            ->messages()
            ->where('sender_id', '!=', auth()->user()->id)
            ->whereNull('seen_at')
            ->update(['seen_at' => now()]);
        return true;
    }

    public function sendMessage(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required',
        ]);

        $conversation = Conversation::matchConversation($user, auth()->user());

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => auth()->user()->id,
                'user_two_id' => $user->id,
            ]);
        }

        $message = $conversation->messages()->create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $user->id,
            'message' => $request->message,
        ]);

        $conversation->touch();

        return $message;
    }
}
