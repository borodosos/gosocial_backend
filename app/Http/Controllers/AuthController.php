<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|min:4',
            'secondName' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag());;
        }

        if (User::where('email', $request->email)->exists()) {
            return response()->json(['error' => 'This user is already registered']);
        };

        User::firstOrCreate([
            'first_name' => $request->firstName,
            'second_name' => $request->secondName,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $req = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('GRANT_PASSWORD'),
            'username' => request('email'),
            'password' => request('password'),
            'scope' => ''
        ]);

        $res = app()->handle($req);
        $responseBody = json_decode($res->getContent()); // convert to json object

        return response()->json($responseBody, $res->getStatusCode());
    }
}