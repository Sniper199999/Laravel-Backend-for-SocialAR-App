<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;


class Media extends Model
{
    use HasFactory, SpatialTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'caption',
        'image_path',
        'width',
        'height',
        'compass_direction',
        'total_comments',
        //'user_loaction',
        'total_likes',
    ];


    protected $spatialFields = [
        'position'
    ];


    public function comments()
    {
        return $this->hasMany(Comments::class);
    }
}
