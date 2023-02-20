<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $comments = Post::find()
        return response()->json('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $user = Auth::user();
        if ($request->comment) {
            $post = Post::find($id);
            $newComment = new Comment(['text' => $request->comment, 'user_id' =>  $user->id]);
            $post->comments()->save($newComment);
        } else if ($request->reply) {
            $comment = Comment::find($request->commentId);
            $reply = new Comment(['text' => $request->reply, 'user_id' => $user->id]);

            $comment->replies()->save($reply);
        } else {
            return response()->json(['error' => 'Something went wrong...'], 400);
        }

        return response()->json('Success', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::find(1);
        return response()->json($comment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json();
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

        if ($request->commentContent) {
            Comment::where('id', $id)->update(['text' => $request->commentContent]);
        } else if ($request->replyContent) {
            Comment::where('id', $id)->update(['text' => $request->replyContent]);
        } else {
            return response()->json(['error' => 'Something went wrong...'], 400);
        }

        return response()->json('Success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if ($comment->replies->isEmpty()) {
            $comment->delete();
            return response()->json('Success deleting comment', 200);
        } else {
            $comment->replies()->delete();
            $comment->delete();
            return response()->json('Success deleting comment with replies', 200);
        }
    }
}