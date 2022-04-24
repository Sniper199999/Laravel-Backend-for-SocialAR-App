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
        $image1 = Storage::disk('public')->putFile('users_media', $qqq);
        $image_url = Storage::url($image1);
        $basename = basename($image_url);

        $qwe = $this->faker->latitude();
        $qwe1 = $this->faker->longitude();
        
    
        $loc = array();
        //Vasai
        $cood_1 = array(); 
        $cood_1[] = rand_float(19.364108,19.391966);
        $cood_1[] = rand_float(72.810590, 72.836317);
        $loc[] = $cood_1;
        
        //Virar
        $cood_2 = array(); 
        $cood_2[] = rand_float(19.448449,19.462525);
        $cood_2[] = rand_float(72.799873, 72.819856);
        $loc[] = $cood_2;

        //Palghar
        $cood_3 = array(); 
        $cood_3[] = rand_float(19.691337,19.715975);
        $cood_3[] = rand_float(72.762142, 72.793665);
        $loc[] = $cood_3;

        $random_loc_index = array_rand($loc);
        $random_location = $loc[$random_loc_index];
        $lat = $random_location[0];
        $lng = $random_location[1];

        error_log(DB::raw("PointFromText('POINT(140.7484404 -73.9878441)')"));

        return [
            'image_path' => $basename,
            'width' => 640,
            'height' => 480,
            'position' => DB::raw("PointFromText('POINT($lat $lng)')"),
            'anchor_id' => "",
            'anchor_name' => "",
            //'position' => DB::raw("PointFromText('POINT(140.7484404 -73.9878441)')"),
            'compass_direction' => $this-> faker->biasedNumberBetween(0,360),
            'user_id' => $this->faker->randomDigitNotNull(),
            'total_comments' => $this->faker->randomDigitNotNull(),
            'total_likes' => $this->faker->randomDigitNotNull(),
            //'caption' => $this->faker->name(),
            'caption' => $this->faker->realText(mt_rand(20, 500)),
            'ref_img' => "",

        ];
    }
    //4326
}

function rand_float($st_num=0,$end_num=1,$mul=1000000)
        {
            if ($st_num>$end_num) return false;
            return mt_rand($st_num*$mul,$end_num*$mul)/$mul;
        }
