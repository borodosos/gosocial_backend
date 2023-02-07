<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Traits\HasFile;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HasFile;
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

    public function update(Request $request)
    {
        $authUser = Auth::guard('api')->user();
        $keys = $request->keys();

        // $pathToFile = $this->hasFile($request);
        // $updated = User::where('id', $authUser->id)->update(["$keys[0]" => $request[$keys[0]]]);
        $path = $request->file('file')->getRealPath();
        $logo = file_get_contents($path);
        $base64 = base64_encode($logo);

        return response($base64);
    }
}