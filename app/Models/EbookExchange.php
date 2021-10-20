<?php

namespace App\Models;

use App\Traits\ExchangeTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookExchange extends Model
{
    use HasFactory, ExchangeTrait, Searchable;

    protected $guarded = [];
}
