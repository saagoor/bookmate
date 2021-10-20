<?php

namespace App\Models;

use App\BookScraper;
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
    protected $withCount = ['reviews', 'months_exchanges', 'months_challenges', 'months_reads'];

    public static array $searchables = [
        'name',
        'isbn',
        'category',
        'publisher:name,email',
        'authors:name,email',
    ];

    public static array $categories = [
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
        return $this->morphMany(Review::class, 'reviewable')->latest('updated_at');
    }

    public function exchanges()
    {
        return $this->hasMany(Exchange::class)->whereNull('exchange_id');
    }

    public function months_exchanges()
    {
        return $this
            ->exchanges()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }

    public function months_challenges()
    {
        return $this
            ->challenges()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    public function reads()
    {
        return $this->belongsToMany(User::class, 'books_reads')->withTimestamps();
    }

    public function months_reads()
    {
        return $this->reads()
            ->whereMonth('books_reads.updated_at', now())
            ->whereYear('books_reads.updated_at', now());
    }

    //    Utilities
    public static function getForSelector()
    {
        return Book::with('authors')
            ->without(['writers', 'translators'])
            ->latest('name')
            ->get(['id', 'name', 'cover']);
    }

    public function getPrice()
    {
        if ($this->price) {
            return $this->price;
        }
        return BookScraper::url('search')
            ->params(['term' => $this->name])
            ->get()
            ->price();
    }
//    Attributes
    public function getWriterAttribute() {
        return $this->writers->pluck('name')->join(', ');
    }
}
