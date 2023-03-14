<?php

namespace App\Http\Controllers;

use App\Events\RoomEvent;
use App\Models\Message;
use App\Models\Room;
use App\Traits\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    use SendNotification;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function store(Request $request)
    {

        $auth_user = Auth::guard('api')->user();

        if (!$request->filled('message')) {
            return response()->json([
                'error' => 'No message to send'
            ], 422);
        }
        $room = Room::find($request->room_id);
        $new_message = new Message([
            'user_id' => $auth_user->id,
            'content' => $request->message,
        ]);
        $room->messages()->save($new_message);

        $message = $room->messages->find($new_message->id);
        event(new RoomEvent($message, $request->room_id));


        $this->sendNotification($request->user_to_id);

        return response()->json($room->messages->find($new_message->id), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $messages = Message::where('room_id', $id)->get();
        return response()->json($messages, 200);
    }
}
