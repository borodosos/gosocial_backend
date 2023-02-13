<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json($url);
    }

    public function loginWithGoogle(Request $request)
    {
        $google_user = Socialite::driver('google')->stateless()->user();

        $founded_user = User::where('google_id', $google_user->id)->first();

        if ($founded_user) {
            $req = Request::create('/oauth/token', 'POST', [
                'grant_type' => 'password',
                'client_id' => config('passport.password_grant_client.id'),
                'client_secret' => config('passport.password_grant_client.secret'),
                'username' => $founded_user->email,
                'password' => 'nopass',
                'scope' => '',
            ]);


            $res =  app()->handle($req);
            $responseBody =  json_decode($res->getContent());

            return redirect("http://localhost:8080/")->withCookie('refreshToken', $responseBody->refresh_token);
            // return redirect("http://localhost:8080");
            // return redirect()->route('login', $founded_user);
            // return response()->json($responseBody);
        } else {

            $new_user = User::create([
                'first_name' => $google_user->given_name,
                'second_name' => $google_user->family_name,
                'email' => $google_user->email,
                'google_id' => $google_user->id,
                'password' => Hash::make('nopass'),
            ]);

            $req = Request::create('/oauth/token', 'POST', [
                'grant_type' => 'password',
                'client_id' => config('passport.password_grant_client.id'),
                'client_secret' => config('passport.password_grant_client.secret'),
                'username' => $new_user->email,
                'password' => 'nopass',
                'scope' => '',
            ]);


            $res =  app()->handle($req);
            $responseBody =  json_decode($res->getContent());

            return redirect('http://localhost:8080/')->withCookie(cookie('refreshToken', $responseBody->refresh_token));
        }
    }
}