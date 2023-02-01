<?php

namespace App\Claims;

use CorBosman\Passport\AccessToken;
use Illuminate\Support\Facades\Auth;

class CustomClaim
{
    public function handle(AccessToken $token, $next)
    {
        $user = Auth::user();

        $token->addClaim('my-claimsssss', $user);
        return $next($token);
    }
}