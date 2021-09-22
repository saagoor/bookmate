<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['image_url'];

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

    public function imageable()
    {
        return $this->morphTo();
    }
}
