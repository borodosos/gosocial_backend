<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            return response()->json(['error' => 'This user is already registered'], 401);
        };

        User::firstOrCreate([
            'first_name' => $request->firstName,
            'second_name' => $request->secondName,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $req = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => config('passport.password_grant_client.id'),
            'client_secret' => config('passport.password_grant_client.secret'),
            'username' => request('email'),
            'password' => request('password'),
            'scope' => ''
        ]);

        $res = app()->handle($req);
        $responseBody = json_decode($res->getContent());

        return response()->json($responseBody, $res->getStatusCode());
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $req = Request::create('/oauth/token', 'POST', [
                'grant_type' => 'password',
                'client_id' => config('passport.password_grant_client.id'),
                'client_secret' => config('passport.password_grant_client.secret'),
                'username' => request('email'),
                'password' => request('password'),
                'scope' => ''
            ]);

            $res = app()->handle($req);
            $responseBody = json_decode($res->getContent());


            $cookie = cookie('refreshToken', $responseBody->refresh_token, 1440);
            return response()->json(['token_data' => $responseBody, "user_data" => $user], $res->getStatusCode())->cookie($cookie);
        } else {
            return response()->json(['error' => 'Incorrect password or email'], 401);
        }
    }

    public function refresh()
    {
        $req = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => request('refreshToken'),
            'client_id' => config('passport.password_grant_client.id'),
            'client_secret' => config('passport.password_grant_client.secret'),
            'scope' => ''
        ]);

        $res = app()->handle($req);
        $responseBody = json_decode($res->getContent());


        return response()->json($responseBody, $res->getStatusCode());
    }
}