<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Traits\HasFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\type;

class PostController extends Controller
{

    use HasFile;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->keywords) {
            switch ($request->selectedFilter) {
                case 'Authors':
                    $posts = Post::whereHas('user', function ($query) use ($request) {
                        $query->where('first_name', 'LIKE', "%$request->keywords%")
                            ->orWhere('second_name', 'LIKE', "%$request->keywords%");
                    })->with('tags')->with('user')->latest()->paginate(3);
                    break;

                case 'Tags':
                    $posts = Post::whereHas('tags', function ($query) use ($request) {
                        $query->where('tag_text', 'LIKE', "%$request->keywords%");
                    })->with('tags')->with('user')->latest()->paginate(3);
                    break;

                default:
                    $posts = Post::where('title', 'LIKE', "%$request->keywords%")
                        ->orWhere('text', 'LIKE', "%$request->keywords%")
                        ->orWhereHas('tags', function ($query) use ($request) {
                            $query->where('tag_text', 'LIKE', "%$request->keywords%");
                        })
                        ->orWhereHas('user', function ($query) use ($request) {
                            $query->where('first_name', 'LIKE', "%$request->keywords%")
                                ->orWhere('second_name', 'LIKE', "%$request->keywords%");
                        })
                        ->with('tags')->with('user')->latest()->paginate(3);
                    break;
            }
            return response()->json(['posts' => $posts, 'keywords' => $request->keywords, 'filter' => $request->selectedFilter]);
        }

        $posts = Post::with('tags')->with('user')->latest()->paginate(3);

        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'text' => 'required',
            'image' => 'required',
            'tags' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 400);;
        }

        $pathToFile = $this->hasFile($request);

        $user = Auth::guard('api')->user();

        $post = Post::create([
            'title' => $request->title,
            'text' => $request->text,
            'image' =>   $pathToFile,
            'user_id' => $user->id
        ]);

        $tags = Tag::whereIn('tag_text', explode(',', $request->tags))->get();
        $post->tags()->attach($tags);

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::where('user_id', $id)->with('tags')->with('user')->get();
        return response()->json($posts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return response()->json('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        return response()->json('update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return response()->json('destroy');
    }
}