<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();

        return response()->json($users);
    }

    public function show(User $user)
    {
        $posts = $user->posts()->with('tags')->get();
        $user['posts'] = $posts;
        return response()->json($user);
    }
}