<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Http;
use Image;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Faker\Generator;



class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->input('id');
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $range = 600;
        $km = $range/1000;

            $myData = DB::select(DB::raw("
                    select m.id, user_id, caption, image_path, u.user_dp, st_x(position) lat, st_y(position) lng, compass_direction, total_comments, total_likes, anchor_id, ref_img 
                    from media m 
                    LEFT JOIN users u ON m.user_id = u.id 
                    where user_id IN (SELECT friend_id FROM friends WHERE user_id = :id)
                    and st_contains(st_makeEnvelope(point((:lat1 + :km1 / 111),(:lng1 + :km2 / 111)),
                                                    point((:lat2 - :km3 / 111),(:lng2 - :km4 / 111))), position)"),
                    array('id' => $id, 'km1' => $km, 'km2' => $km, 'km3' => $km, 'km4' => $km, 'lat1' => $lat, 'lng1' => $lng, 'lat2' => $lat, 'lng2' => $lng,)
                    );
            return $myData;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        //
    }

     public function OpenPic(Request $request) {
         $img_id = $request->input('img_id');
         $img_path = Media::find($img_id);
         return $img_path;
     }

    //TRAIL
    // public function OpenPic(Request $request) {
    //     $img = $request;
    //     $process = new Process(['python', "C:/laragon/www/social-app/public/python/test.py"]);
    //     $process->run();
    
    //     if (!$process->isSuccessful()) {
    //         throw new ProcessFailedException($process);
    //     }

    //     $data = $process->getOutput();

    //     dd($data);
    //     return $data;
    // }

    

    public function UploadImg(Request $request) {
        $fields = $request->validate([
            'user_id' => 'required|integer',
            'caption' => 'string',
            'image' => 'required|image:jpeg,png,jpg,gif,svg',
            'width' => 'integer',
            'height' => 'integer',
            'lat' => 'string',
            'lng' => 'string',
            'anchor_id' => 'string',
            'anchor_name' => 'string',
            'compass_direction' => 'required|integer',
            'total_comments' => 'integer',
            'total_likes' => 'integer',
            'ref_img' => 'required|image:jpeg,png,jpg,gif,svg',
        ]);

        //Upload User_DP
        $uploadFolder = 'users_media_full';
        $image = $request->file('image');
        $randomname = Str::random(40).'.jpg';
        $image_uploaded_path = $image->storeAs($uploadFolder, $randomname, 'public');
        //$image_url = Storage::url($image_uploaded_path);
        $image_url = basename($image_uploaded_path);

        $image2_uploaded_path = $request->file('image')->storeAs('blurred_users_media', $randomname, 'public');
        $image2_url = Storage::url($image2_uploaded_path);
        
        $image3_uploaded_path = $request->file('image')->storeAs('users_media_mid', $randomname, 'public');
        $image3_url = Storage::url($image3_uploaded_path);

        $image4_uploaded_path = $request->file('image')->storeAs('users_media_small', $randomname, 'public');
        $image4_url = Storage::url($image4_uploaded_path);

        $blur_path = public_path().'\storage\blurred_users_media\\'.$randomname;
        $full_media_path = public_path().'\storage\users_media_full\\'.$randomname;
        $mid_media_path = public_path().'\storage\users_media_mid\\'.$randomname;
        $small_media_path = public_path().'\storage\users_media_small\\'.$randomname;
       // $image_url = Storage::url($image_uploaded_path);
        $image2_url = Storage::url($image2_uploaded_path);

        //reference image
        $RefFolder = 'ref_img';
        $ref_img = $request->file('ref_img');
        $ref_randomname = Str::random(40).'.jpg';
        $ref_img_uploaded_path = $ref_img->storeAs('ref_img', $ref_randomname, 'public');
        $ref_image_url = basename($ref_img_uploaded_path);
        $ref_path = public_path().'\storage\ref_img\\'.$ref_randomname;

        $responze = Http::post('http://127.0.0.1:5000/media_compressblur', [
            'full_img' => $full_media_path,
            'mid_img' => $mid_media_path,
            'small_img' => $small_media_path,
            'blur_img' => $blur_path,
            'ref_img' => $ref_path,
        ]);
        $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
        );
        

        //$position = DB::raw("PointFromText('POINT(140.7484404 -73.9878441)')");

        $user_media = Media::create([
            'user_id' => $fields['user_id'],
            'caption' => $fields['caption'],
            'image_path' => $image_url,
            'width' => $fields['width'],
            'height' => $fields['height'],
            'position' => "",
            'anchor_id' => $fields['anchor_id'],
            'anchor_name' => Str::random(15),
            'compass_direction' => $fields['compass_direction'],
            'total_comments' => $fields['total_comments'],
            'total_likes' => $fields['total_likes'],
            'ref_img' => $ref_image_url,
        ]);

        $lat = $fields['lat'];
        $lng = $fields['lng'];
        $point = new Point($lng, $lat);
        //$point = new Point(40.7484404, -73.9878441);
        $point->toJson();
        $user_media->position = $point;
        $user_media->save();

        $response = [
            'media' => $user_media,
            'image' => $uploadedImageResponse,
        ];

        return response($response, 201);
    }


    public function getCommentsOnPic(Request $request) {
        $img_id = $request->input('img_id');
        $img_path = Media::find($img_id);

        $id = $request->input('media_id');
        $try = $img_id->comments->where('media_id', $id)
                                ->orderBy('created_at')
                                ->get();
        // $party = Comments::where('media_id', $id)
        //                     ->orderBy('created_at')
        //                     ->get();
       // $candidates = $party->medias; // Returns a Laravel Collection
        return;
    }

    public function flask(Request $request){
        
        $user_id = $request->input('user_id');
       // $user_id = $request->input('user_id');
        $response = Http::post('http://127.0.0.1:5000/getFOF',[
            'user_id' => $user_id,
        ]);
       
        return response($response) ->header('Content-Type', 'application/json');
      
    }


    public function getuserinfo(Request $request) {
        $id = $request->input('id');
        $friend_id = 112;
        //$candidates = Media::all();
        //$party = User::find($id);
        //$candidates = $party->medias; // Returns a Laravel Collection User.php

        $totalpost = DB::table('media')
            ->select(DB::raw("count(id) as totalmedia"))
            ->where('user_id','=',$id)
            ->get();

        $followers = DB::table('friends')
            ->select(DB::raw("count(user_id) as followers"))
            ->where('friend_id','=',$id)
            ->get();

        $following = DB::table('friends')
            ->select(DB::raw("count(friend_id) as following"))
            ->where('user_id','=', $id)
            ->get();

        $data2 = [];
        
      //  $data2[0] =  [, , ];
        $data2[0] = [
            'totalpost' => current($totalpost[0]),
            'followers' => current($followers[0]),
            'following' => current($following[0]),
        ];
            
        

        // $current_date_time = Carbon::now()->toIso8601String();
        // foreach($candidates as $i){
        //      $i->current_time = $current_date_time;
        // }
        return $data2;
    }


    public function getmediaofuser(Request $request) {
        $id = $request->input('id');
        $friend_id = 112;
        //$candidates = Media::all();
        //$party = User::find($id);
        //$candidates = $party->medias; // Returns a Laravel Collection User.php
         $candidates = Media::query()
            ->select('media.*', 'users.username', 'users.user_dp')
            ->join('users','users.id','=','media.user_id')
            ->where('media.user_id','=',$id)
            ->get();

        $current_date_time = Carbon::now()->toIso8601String();
        foreach($candidates as $i){
             $i->current_time = $current_date_time;
        }
        return $candidates;
    }

    public function getMediaa(Request $request) {
        $id = $request->input('id');
        $friend_id = 112;
        //$candidates = Media::all();
         $candidates = Media::query()
            ->select(DB::raw("IFNULL(unlockeds.friend_id, 112) as friend_id"), DB::raw("IFNULL(unlockeds.media_unlocked, 0) as media_unlocked"), 'media.*')
            ->leftJoin('unlockeds',function($join) {
                $join->on('unlockeds.user_id','=','media.user_id')
                ->on('media.id','=','unlockeds.media_id')
                ->where('unlockeds.friend_id','=',112);
            })
            ->where('media.user_id','=',26)
            ->orderBy('media.created_at','asc')
            ->orderBy('media.id','asc')
            ->get();

        $current_date_time = Carbon::now()->toIso8601String();
        foreach($candidates as $i){
             $i->current_time = $current_date_time;
        }
        return $candidates;
    }

    public function homepage(Request $request) {
        $id = $request->input('id');
        //$friend_id = 112;
        //$candidates = Media::all();
        $candidates = Media::query()
            ->select('users.user_dp', 'users.username', DB::raw("users.name as fullname") ,DB::raw("IFNULL(unlockeds.friend_id, '$id') as friend_id"),
                 DB::raw("IFNULL(unlockeds.media_unlocked, 0) as media_unlocked"), DB::raw("IFNULL(likes.user_id, 0) AS hasuserliked"),
                 'media.*')
            ->leftJoin('unlockeds', function($join) use ($id) {
                $join->on('unlockeds.user_id','=','media.user_id')
                ->on('media.id','=','unlockeds.media_id')
                //->on('unlockeds.friend_id','=', $id);
                ->where('unlockeds.friend_id','=', $id);
            })
            ->leftJoin('likes', function($join) use ($id) {
                $join->on('media.id','=','likes.media_id')
                ->where('likes.user_id','=', $id);
            })
            //JOIN users u ON u.id = m.user_id
            ->join('users', function($join1) {
                $join1->on('users.id' ,'=', 'media.user_id');
            })
            ->whereIn('media.user_id',function ($query) use ($id) {
                $query->from('friends')
                    ->select('friends.friend_id')
                    ->where('friends.user_id','=',$id);
            })
            ->orderBy('media.created_at','asc')
            ->orderBy('media.id','asc')
            ->get();

        $current_date_time = Carbon::now()->toIso8601String();
        foreach($candidates as $i){
             $i->current_time = $current_date_time;
        }
        return $candidates;
    }

    public function totalposts(Request $request) {
        $id = $request->input('id');
         $candidates = Media::query()
            ->select(DB::raw("COUNT(id) as totalmedia"))
            ->where('user_id','=',$id)
            ->get();
        return $candidates;
    }

    public function insertmediadata(Request $request)
    {
        if (($handle = fopen ( public_path () . '/posts_sorted2.csv', 'r' )) !== FALSE) {
            //$faker = Faker\Factory::create();
            set_time_limit(10800);
            $faker = Container::getInstance()->make(Generator::class);
            while ( ($data = fgetcsv ( $handle, 1000, ',' )) !== FALSE ) {

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

                $csv_data = new Media ();
                //$csv_data->id = $data [0];
                $csv_data->user_id = $data [0];
                $csv_data->caption = $faker->realText(mt_rand(20, 255));
                $csv_data->image_path = $data [1];
                $csv_data->width = $data [2];
                $csv_data->height = $data [3];
                $csv_data->position = DB::raw("PointFromText('POINT($lat $lng)')");
                $csv_data->anchor_id = Null;
                $csv_data->anchor_name = Null;
                $csv_data->compass_direction = $faker->biasedNumberBetween(1, 360);
                $csv_data->total_comments = 0;
                $csv_data->total_likes = 0;
                $csv_data->ref_img = Null;
                $csv_data->save ();
            }
            fclose ( $handle );
        }
        return "Done";
    }
}

function rand_float($st_num=0,$end_num=1,$mul=1000000)
        {
            if ($st_num>$end_num) return false;
            return mt_rand($st_num*$mul,$end_num*$mul)/$mul;
        }

