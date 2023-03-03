<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->filled('message')) {
            return response()->json([
                'error' => 'No message to send'
            ], 422);
        }

        event(new NewChatMessage($request->message, $request->user));

        return response()->json([], 200);
    }
}
