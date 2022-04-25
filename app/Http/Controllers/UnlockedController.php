<?php

namespace App\Http\Controllers;

use App\Models\Unlocked;
use Illuminate\Http\Request;

class UnlockedController extends Controller
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
     * @param  \App\Models\Unlocked  $unlocked
     * @return \Illuminate\Http\Response
     */
    public function show(Unlocked $unlocked)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unlocked  $unlocked
     * @return \Illuminate\Http\Response
     */
    public function edit(Unlocked $unlocked)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unlocked  $unlocked
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unlocked $unlocked)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unlocked  $unlocked
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unlocked $unlocked)
    {
        //
    }


    public function mediaunlocked(Request $request) {

        $fields = $request->validate([
            'user_id' => 'required|integer',
            'media_id' => 'required|integer',
            'friend_id' => 'required|integer',
            'media_unlocked' => 'required|integer',
        ]);

        $Like = Unlocked::where([['media_id', '=', $fields['media_id']], 
        ['friend_id', '=', $fields['friend_id']]])->first();

        if($Like === null){
            $Like = Unlocked::create([
                'user_id' => $fields['user_id'],
                'media_id' => $fields['media_id'],
                'friend_id' => $fields['friend_id'],
                'media_unlocked' => $fields['media_unlocked'],
            ]);
            $Like->save();
        }
        $response = [
            '0' => $Like,
        ];

        return response($response, 201);
    }
}
