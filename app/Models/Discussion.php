<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];
    protected $withCount = ['all_comments as comments_count'];

    protected static $searchables = [
        'title',
        'body',
        'user:name,email'
    ];

    public function comments()
    {
        return $this
            ->hasMany(Comment::class)
            ->whereNull('comment_id')
            ->latest();
    }

    public function all_comments()
    {
        return $this
            ->hasMany(Comment::class)
            ->latest();
    }

    public function discussable()
    {
        return $this->morphTo('discussable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
