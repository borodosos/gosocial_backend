<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Models\User as ModelsUser;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return ModelsUser::all();
    }
}