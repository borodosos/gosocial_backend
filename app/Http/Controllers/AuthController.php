<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public $client;

    public function __construct()
    {
        $this->client = DB::table('oauth_clients')
            ->where('id', 2)
            ->first();
    }

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
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => request('email'),
            'password' => request('password'),
            'scope' => ''
        ]);

        $res = app()->handle($req);
        $responseBody = json_decode($res->getContent());

        return response()->json($responseBody, $res->getStatusCode())->withCookie('refreshToken', $responseBody->refresh_token);
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $req = Request::create('/oauth/token', 'POST', [
                'grant_type' => 'password',
                'client_id' => $this->client->id,
                'client_secret' => $this->client->secret,
                'username' => request('email'),
                'password' => request('password'),
                'scope' => '',
            ]);


            $res =  app()->handle($req);
            $responseBody =  json_decode($res->getContent());
            return response()->json($responseBody, $res->getStatusCode())->withCookie('refreshToken', $responseBody->refresh_token);
        } else {
            return response()->json(['error' => 'Incorrect password or email'], 400);
        }
    }

    public function refresh()
    {
        $req = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => request()->cookie('refreshToken'),
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => ''
        ]);

        $res = app()->handle($req);
        $responseBody = json_decode($res->getContent());

        return response()->json($responseBody, $res->getStatusCode())->withCookie('refreshToken', $responseBody->refresh_token);
    }
}
