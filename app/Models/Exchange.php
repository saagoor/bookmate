<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];
    
    public static $searchables = [
        'book_condition',
        'book:name,isbn,category',
        'user:name,email',
        'book.writers:name',
        'book.translators:name',
    ];

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

    public function previews()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    // Attributes
    public function getCurrentUserSentOfferAttribute()
    {
        if (!auth()->check()) {
            return false;
        }
        if ($this->relationLoaded('offers')) {
            return $this->offers->where('user_id', auth()->user()->id)->count();
        }
        return $this->offers()->where('user_id', auth()->user()->id)->exists();
    }
}
