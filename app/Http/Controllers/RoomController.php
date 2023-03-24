<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json('dads');
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
        $auth_user = Auth::guard('api')->user();
        $user_to = User::find($request->friend_id);


        $founded_user = User::whereHas('rooms', function ($query) use ($auth_user, $user_to) {
            $query->where([['user_id', $auth_user->id], ['user_to_id', $user_to->id]])
                ->orWhere([['user_id', $user_to->id], ['user_to_id', $auth_user->id]]);
        })->get();

        if ($founded_user->isEmpty()) {
            $room = Room::firstOrCreate(['room_name' => 'Room ' . $auth_user->second_name . '-' . $user_to->second_name]);
            $auth_user->rooms()->attach($room->id, ['user_to_id' => $user_to->id]);

            $room_data = $auth_user->rooms()
                ->where([['user_id', $auth_user->id], ['user_to_id', $user_to->id]])
                ->orWhere([['user_id', $user_to->id], ['user_to_id', $auth_user->id]])->get();

            return response()->json(['message' => 'Room created', 'room_data' => $room_data[0]], 200);
        } else {
            $room_data = $founded_user[0]->rooms()
                ->where([['user_id', $auth_user->id], ['user_to_id', $user_to->id]])
                ->orWhere([['user_id', $user_to->id], ['user_to_id', $auth_user->id]])->get();
            return response()->json($room_data[0], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
