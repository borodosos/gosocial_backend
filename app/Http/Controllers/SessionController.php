<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
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

        // $user_sessions = $auth_user->sessions->whereHas('session_user', function ($query) {
        //     $query->where('user_id', 1);
        // })->get();

        $user_sessions = Session::find(14);

        // if ($auth_user->sessions->isEmpty() || $user_to->sessions->isEmpty()) {
        //     $session = Session::firstOrCreate(['session_name' => 'Session ' . $auth_user->second_name . '-' . $user_to->second_name]);
        //     $auth_user->sessions()->syncWithoutDetaching($session->id);
        //     $user_to->sessions()->syncWithoutDetaching($session->id);
        // }

        // return response()->json(['session_data' => $auth_user->sessions[0]], 200);
        return response()->json($user_sessions);
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
