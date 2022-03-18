<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use \Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $image = $this->faker->image();
        $qqq = new File($image);
        $image1 = Storage::disk('public')->putFile('users_dp', $qqq);
        $image_url = Storage::url($image1);

        $qwe = $this->faker->latitude();
        $qwe1 = $this->faker->longitude();
        error_log(DB::raw("PointFromText('POINT(140.7484404 -73.9878441)')"));

        return [
            'image_path' => $image_url,
            'width' => 640,
            'height' => 480,
            'position' => DB::raw("ST_PointFromText('POINT($qwe $qwe1)')"),
            //'position' => DB::raw("PointFromText('POINT(140.7484404 -73.9878441)')"),
            'compass_direction' => $this-> faker->biasedNumberBetween(0,360),
            'user_id' => $this->faker->randomDigitNotNull(),
            'total_comments' => $this->faker->randomDigitNotNull(),
            'total_likes' => $this->faker->randomDigitNotNull(),
            //'caption' => $this->faker->name(),
            'caption' => $this->faker->sentence(),

        ];
    }
    //4326
}
