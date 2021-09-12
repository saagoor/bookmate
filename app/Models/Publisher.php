<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Publisher extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        if(Str::startsWith($this->image, 'http')){
            return $this->image;
        }
        return asset($this->image);
    }
}
