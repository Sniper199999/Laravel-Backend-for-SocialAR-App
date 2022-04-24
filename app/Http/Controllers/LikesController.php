<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Likes  $likes
     * @return \Illuminate\Http\Response
     */
    public function show(Likes $likes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Likes  $likes
     * @return \Illuminate\Http\Response
     */
    public function edit(Likes $likes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Likes  $likes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Likes $likes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Likes  $likes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Likes $likes)
    {
        //
    }

    public function likemedia(Request $request) {

        $fields = $request->validate([
            'user_id' => 'required|integer',
            'media_id' => 'required|integer',
        ]);

        $Like = Likes::create([
            'user_id' => $fields['user_id'],
            'media_id' => $fields['media_id'],
        ]);
        $Like->save();

        $response = [
            '0' => $Like,
        ];

        return response($response, 201);
    }

    public function unlike(Request $request) {
        
        $user_id = $request->input('user_id');
        $media_id = $request->input('media_id');
      
        $Like = Likes::where([['user_id', '=', $user_id], 
                        ['media_id', '=', $media_id]])->delete();
        

        $response = [
            '0' => "Deleted",
        ];

        return response($response, 201);
    }

}
