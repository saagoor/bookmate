<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Exchange extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    /**
     * Modify the query used to retrieve models when making all of the models searchable.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function makeAllSearchableUsing($query)
    {
        return $query->with(['book', 'user', 'expected_book']);
    }
    public function toSearchableArray()
    {
        $this->book;
        $this->book->authors;
        $this->user;
        $array = $this->toArray();
        return $array;
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function expected_book()
    {
        return $this->belongsTo(Book::class);
    }

    public function offers()
    {
        return $this->hasMany(ExchangeOffer::class);
    }

    public function accepted_offer()
    {
        return $this->belongsTo(ExchangeOffer::class);
    }

    // Attributes
    public function getCurrentUserSentOfferAttribute()
    {
        if(!auth()->check()){
            return false;
        }
        if($this->relationLoaded('offers')){
            return $this->offers->where('user_id', auth()->user()->id)->count();
        }
        return $this->offers()->where('user_id', auth()->user()->id)->exists();
    }
}
