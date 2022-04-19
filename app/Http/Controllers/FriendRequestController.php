<?php

namespace App\Http\Controllers;

use App\Models\Friend_request;
use Illuminate\Http\Request;
use App\Models\User;


class FriendRequestController extends Controller
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
     * @param  \App\Models\Friend_request  $friend_request
     * @return \Illuminate\Http\Response
     */
    public function show(Friend_request $friend_request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Friend_request  $friend_request
     * @return \Illuminate\Http\Response
     */
    public function edit(Friend_request $friend_request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Friend_request  $friend_request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Friend_request $friend_request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Friend_request  $friend_request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Friend_request $friend_request)
    {
        //
    }

    public function friendreq(Request $request) {
        $id = $request->input('id');
        //$candidates = Media::all();
         $candidates = Friend_request::query()      
            ->select('users.id', 'users.username', 'users.name', 'users.email', 'users.user_dp')
            ->leftJoin('users','friend_requests.user_id','=','users.id')
            ->where('friend_requests.requested_user_id','=',$id)
            ->get();
        return $candidates;
    }
}
