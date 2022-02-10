<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use \Illuminate\Support\Facades\DB;
use Grimzy\LaravelMysqlSpatial\Types\Point;




class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SpatialTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password' ,
        'email_verified_at',
        'user_dp',
        //'user_loaction',
        'user_avatar',
        'active'
    ];

    protected $spatialFields = [
        'user_location'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   

    public function medias()
    {
        return $this->hasMany(Media::class);
       
    }

    public function friends()
    {
        return $this->hasMany(Friends::class);
    }

    public function friend_request()
    {
        return $this->hasMany(Friend_request::class);
    }

    public function likes()
    {
        return $this->hasMany(Likes::class);
    }

    // public function comments()
    // {
    //     return $this->hasMany(Comments::class);
    // }

    public function unlocked()
    {
        return $this->hasMany(Unlocked::class);
    }

}
