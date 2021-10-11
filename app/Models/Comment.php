<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $withCount = ['replies'];

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }
}
