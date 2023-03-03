<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$request->filled('message')) {
            return response()->json([
                'error' => 'No message to send'
            ], 422);
        }

        // $message = ChatMessage::create([
        //     'user_id' => $request->user->id,
        //     'text' => $request->message,
        // ]);



        event(new NewChatMessage($request->message, $request->to_user, $user));

        return response()->json([], 200);
    }
}
