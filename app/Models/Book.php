<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\Searchable;

class Book extends Model
{
    use HasFactory, Searchable;

    protected $dates = ['published_at'];
    protected $guarded = [];
    protected $appends = ['cover_url'];
    protected $with = ['writers', 'translators'];
    protected $withCount = ['reviews', 'exchanges', 'challanges'];

    public static $searchables = [
        'name', 
        'isbn',
        'category',
        'publisher:name,email', 
        'authors:name,email',
    ];

    public static $categories = [
        "Fantasy",
        "Adventure",
        "Romance",
        "Contemporary",
        "Dystopian",
        "Mystery",
        "Horror",
        "Thriller",
        "Paranormal",
        "Historical fiction",
        "Science Fiction",
        "Memoir",
        "Cooking",
        "Art",
        "Self-help / Personal",
        "Development",
        "Motivational",
        "Health",
        "History",
        "Travel",
        "Guide / How-to",
        "Families & Relationships",
        "Humor",
        "Children’s",
    ];


    public function getCoverUrlAttribute()
    {
        if (!$this->cover) {
            return null;
        }
        if (Str::startsWith($this->cover, 'http')) {
            return $this->cover;
        }
        return asset('storage/' . $this->cover);
    }

    public function authors()
    {
        return $this->belongsToMany(Writer::class, 'books_authors');
    }
    public function writers()
    {
        return $this->authors()->wherePivot('translator', false);
    }
    public function translators()
    {
        return $this->authors()->wherePivot('translator', true);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class)->withDefault();
    }

    public function reviews()
    {
       return $this->morphMany(Review::class, 'reviewable');
    }

    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }

    public function challanges()
    {
        return $this->hasMany(Challange::class);
    }
}
