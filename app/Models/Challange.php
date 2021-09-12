<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challange extends Model
{
    use HasFactory;

    protected $dates = ['finish_at'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'challanges_participants')
            ->withTimestamps()
            ->withPivot(['percentage'])
            ->latest('pivot_percentage')
            ->latest('pivot_created_at');
    }
}
