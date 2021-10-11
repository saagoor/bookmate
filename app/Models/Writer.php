<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Writer extends Model
{
    use HasFactory, Searchable;
    protected $guarded = [];
    protected $dates = ['date_of_birth'];

    protected $appends = ['image_url'];

    public static $searchables = [
        'name',
        'email',
        'location',
        'date_of_birth',
        'books:name,isbn,category',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        if (Str::startsWith($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'books_authors')->withAvg('reviews', 'rating');
    }
}
