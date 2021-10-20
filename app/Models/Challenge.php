<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Challenge extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    protected $dates = ['finish_at'];
    protected $withCount = ['participants', 'finishers'];

    public static $searchables = [
        'book:name,isbn,category',
        'user:name,email',
        'book.writers:name',
        'book.translators:name',
    ];

    protected static function booted()
    {
        static::created(function ($challange) {
            $challange->discussion()->create();
        });
    }

    public function book()
    {
        return $this->belongsTo(Book::class)->withAvg('reviews', 'rating')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discussion(){
        return $this->morphOne(Discussion::class, 'discussable');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'challenges_participants')
            ->withTimestamps()
            ->withPivot(['percentage'])
            ->latest('pivot_percentage')
            ->latest('pivot_created_at');
    }

    public function finishers(){
        return $this->participants()->wherePivot('percentage', 100);
    }

    public function addParticipant(User $user)
    {
        $this->participants()->syncWithoutDetaching(auth()->user());
    }

    public function invite(String $email)
    {
        $link = route('challenges.show', $this->id);
        Mail::raw("You have been invited to a book reading challenge. \n\n{$link}", function ($message) use($email) {
            $message->from(auth()->user()->email, auth()->user()->name);
            $message->to($email, User::whereEmail($email)->first()->name ?? '');
            $message->subject('Challenge Invitation');
        });
    }
}
