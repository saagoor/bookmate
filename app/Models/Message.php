<?php

namespace App\Models;

use App\Events\SendMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sender(){
        return $this->belongsTo(User::class);
    }

    public function receiver(){
        return $this->belongsTo(User::class);
    }

    public function user(){
        if ($this->sender_id == auth()->user()->id){
            return $this->receiver();
        }
        return $this->sender();
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['created_at'] = $this->created_at->diffForHumans();
        return $array;
    }

    protected static function booted()
    {
        static::created(function ($message) {
            SendMessage::dispatch($message);
        });
    }

    public static function createMessageForUsers(User $userOne, User $userTwo, string $text){
        $conversation = Conversation::matchConversation($userOne, $userTwo);
        $message = $conversation->messages()->create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $conversation->user_one_id != auth()->user()->id ? $conversation->user_one_id : $conversation->user_two_id,
            'message' => $text,
        ]);
        return $message;
    }
}
