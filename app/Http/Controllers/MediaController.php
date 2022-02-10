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


class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $lat = $request->input('lat');
       $lng = $request->input('lng');
       $range = 150;
       $km = $range/1000;

        $myData = DB::select(DB::raw("
                select id, user_id, caption, image_path, st_x(position) lat, st_y(position) lng, compass_direction, total_comments, total_likes 
                from `media` 
                where st_contains(st_makeEnvelope(point((:lat1 + :km1 / 111),(:lng1 + :km2 / 111)),
                                                  point((:lat2 - :km3 / 111),(:lng2 - :km4 / 111))), position)"),
                array('km1' => $km, 'km2' => $km, 'km3' => $km, 'km4' => $km, 'lat1' => $lat, 'lng1' => $lng, 'lat2' => $lat, 'lng2' => $lng,)
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
            'lat' => 'string',
            'lng' => 'string',
            'compass_direction' => 'required|integer',
            'total_comments' => 'integer',
            'total_likes' => 'integer',
        ]);

        //Upload User_DP
        $uploadFolder = 'users_media';
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $image_url = Storage::url($image_uploaded_path);
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
            'position' => "",
            'compass_direction' => $fields['compass_direction'],
            'total_comments' => $fields['total_comments'],
            'total_likes' => $fields['total_likes'],
        ]);

        $lat = $fields['lat'];
        $lng = $fields['lng'];
        $point = new Point($lat, $lng);
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

}
