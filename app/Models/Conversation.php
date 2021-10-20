<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['user_one', 'user_two'];
    protected $appends = ['user'];

    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function user_one()
    {
        return $this->belongsTo(User::class);
    }

    public function user_two()
    {
        return $this->belongsTo(User::class);
    }

    public function getUserAttribute()
    {
        if ($this->user_one_id == auth()->user()->id) {
            return $this->user_two;
        } else {
            return $this->user_one;
        }
    }

    public function toArray()
    {
        return $this->attributesToArray();
    }

//    Utilities
    public static function matchConversation(User $userOne, User $userTwo)
    {
        return Conversation::query()
            ->where(function ($query) use ($userOne, $userTwo) {
                return $query
                    ->where('user_one_id', $userOne->id)
                    ->where('user_two_id', $userTwo->id);
            })
            ->orWhere(function ($query) use ($userOne, $userTwo) {
                return $query
                    ->where('user_one_id', $userTwo->id)
                    ->where('user_two_id', $userOne->id);
            })
            ->first();
    }
}
