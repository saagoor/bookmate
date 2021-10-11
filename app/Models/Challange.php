<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Challange extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    protected $dates = ['finish_at'];
    protected $withCount = ['participants'];

    public static $searchables = [
        'book:name,isbn,category',
        'user:name,email',
        'book.writers:name',
        'book.translators:name',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class)->withAvg('reviews', 'rating')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    public function participants()
    {
        return $this->belongsToMany(User::class, 'challanges_participants')
            ->withTimestamps()
            ->withPivot(['percentage'])
            ->latest('pivot_percentage')
            ->latest('pivot_created_at');
    }

    public function addParticipant(User $user)
    {
        $this->participants()->syncWithoutDetaching(auth()->user());
    }

    public function invite(String $email)
    {
        $link = route('challanges.show', $this->id);
        Mail::raw("You have been invited to a book reading challange. \n\n{$link}", function ($message) use($email) {
            $message->from(auth()->user()->email, auth()->user()->name);
            $message->to($email, User::whereEmail($email)->first()->name ?? '');
            $message->subject('Challange Invitation');
        });
    }
}
