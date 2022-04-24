<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unlocked extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'media_id',
        'friend_id',
        'media_unlocked',
    ];

}
