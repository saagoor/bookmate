<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $withCount = ['comments'];

    public function comments()
    {
        return $this->hasMany(Comment::class)
            ->where('comment_id', null);
    }

    public function discussable()
    {
        return $this->morphTo('discussable');
    }
}
