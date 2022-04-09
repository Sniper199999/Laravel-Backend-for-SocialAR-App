<?php

namespace App\Http\Controllers;

use App\Models\Friends;
use Illuminate\Http\Request;
use App\Models\User;

class FriendsController extends Controller
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
     * @param  \App\Models\Friends  $friends
     * @return \Illuminate\Http\Response
     */
    public function show(Friends $friends)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Friends  $friends
     * @return \Illuminate\Http\Response
     */
    public function edit(Friends $friends)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Friends  $friends
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Friends $friends)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Friends  $friends
     * @return \Illuminate\Http\Response
     */
    public function destroy(Friends $friends)
    {
        //
    }


    public function following(Request $request) {
        $id = $request->input('id');
        $friend_id = 112;
        //$candidates = Media::all();
         $candidates = User::query()
            ->select('*')
            ->whereIn('users.id',function ($query) use($id) {
                $query->from('friends')
                    ->select('friends.friend_id')
                    ->where('friends.user_id','=',$id);
                })
            ->get();
        return $candidates;
    }



    public function insertfof(Request $request)
    {
        if (($handle = fopen ( public_path () . '/FOF_final_without_duplicates.csv', 'r' )) !== FALSE) {
            //$faker = Faker\Factory::create();
            set_time_limit(10800);
            #$faker = Container::getInstance()->make(Generator::class);
            while ( ($data = fgetcsv ( $handle, 1000, ',' )) !== FALSE ) {
                $csv_data = new Friends ();
                $csv_data->user_id = $data [0];
                $csv_data->friend_id = $data [1];
                $csv_data->save ();
            }
            fclose ( $handle );
        }
        return "Done";
    }
}
