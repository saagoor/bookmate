<?php

namespace App\Traits;

use App\Models\Book;
use App\Models\Image;
use App\Models\User;

trait ExchangeTrait{

    public static $searchables = [
        'book:name,isbn,category',
        'user:name,email',
        'book.writers:name',
        'book.translators:name',
        'book.publisher:name',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class)->withAvg('reviews', 'rating');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function expected_book()
    {
        return $this->belongsTo(Book::class)->withAvg('reviews', 'rating');
    }

    public function offers()
    {
        return $this->hasMany(self::class);
    }

    public function accepted_offer()
    {
        return $this->belongsTo(self::class);
    }

    public function previews()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function current_users_offer()
    {
        return $this->hasOne(self::class)
            ->where('user_id', auth()->user()->id ?? -1)
            ->without(['writers', 'translators']);
    }

//    Attributes
    public function getIsEbookAttribute()
    {
        return get_class($this) == \App\Models\EbookExchange::class;
    }
}