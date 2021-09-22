<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['image_url'];

    public static $searchables = [
        'name',
        'email',
    ];

    public function getImageUrlAttribute()
    {
        $default = "https://avatars.dicebear.com/api/croodles-neutral/:" . $this->email . ".svg";
        $default = "https://unavatar.now.sh/{$this->email}?fallback={$default}";
        if($this->image){
            return asset('storage/' . $this->image);
        }
        return $default;
    }

    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }
}
