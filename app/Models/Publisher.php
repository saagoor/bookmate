<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Publisher extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    public static $searchables = [
        'name',
        'email',
        'phone',
        'books:name,isbn,category',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        if(Str::startsWith($this->image, 'http')){
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
