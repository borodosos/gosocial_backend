<?php

namespace App\Claims;

use App\Models\User;
use CorBosman\Passport\AccessToken;
use Illuminate\Support\Facades\Auth;

class CustomClaim
{
    public function handle(AccessToken $token, $next)
    {
        $user = User::find($token->getUserIdentifier());

        $token->addClaim('user_info', $user);
        return $next($token);
    }
}