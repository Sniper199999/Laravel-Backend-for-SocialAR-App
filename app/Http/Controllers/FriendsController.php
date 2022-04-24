<?php

namespace App\Http\Controllers;

use App\Models\Friends;
use Illuminate\Http\Request;
use App\Models\User;
use \Illuminate\Support\Facades\DB;

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


    public function followers(Request $request) {
        $id = $request->input('id');
        $friend_id = 112;
        //$candidates = Media::all();
         $candidates = User::query()
            ->select('*')
            ->whereIn('users.id',function ($query) use($id) {
                $query->from('friends')
                    ->select('friends.user_id')
                    ->where('friends.friend_id','=',$id);
                })
            ->get();
        return $candidates;
    }

    public function totalfollowers(Request $request) {
        $id = $request->input('id');
         $candidates = Friends::query()
            ->select(DB::raw("count(user_id) as followers"))
            ->where('friend_id','=',$id)
            ->get();
        return $candidates;
    }

    public function totalfollowing(Request $request) {
        $id = $request->input('id');
         $candidates = Friends::query()
            ->select(DB::raw("count(friend_id) as following"))
            ->where('user_id','=',$id)
            ->get();
        return $candidates;
    }


    public function isfriend(Request $request)
    {
       $id = $request->input('id');
       $friend_id = $request->input('fid');

        $myData = DB::select(DB::raw("
                    select exists(SELECT * from friends 
                    WHERE user_id = :fid And friend_id = :uid) AS present"),
                    array('uid' => $id, 'fid' => $friend_id,));
        return $myData;
    }


    public function removefriend(Request $request) {
        
        $user_id = $request->input('user_id');
        $friend_id = $request->input('friend_id');
      
        $Like = Friends::where([['user_id', '=', $user_id], 
                        ['friend_id', '=', $friend_id]])->delete();
        

        $response = [
            '0' => "Deleted",
        ];

        return response($response, 201);
    }


    public function addfriend(Request $request) {

        $fields = $request->validate([
            'user_id' => 'required|integer',
            'friend_id' => 'required|integer',
        ]);

        $Like = Friends::where([['user_id', '=', $fields['user_id']], 
        ['friend_id', '=', $fields['friend_id']]])->first();

        if($Like === null){
            $Like = Friends::create([
                'user_id' => $fields['user_id'],
                'friend_id' => $fields['friend_id'],
            ]);
            $Like->save();
            $response = [
                '0' => $Like,
            ];
    
            return response($response, 201);
        }
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
