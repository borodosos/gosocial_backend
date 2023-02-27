<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required_without:reply|string',
            'reply' => 'required_without:comment|string',
            'commentId' => 'required_if:reply,!=,null|exists:comments,id',
        ]);

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

        $auth_user = Auth::guard('api')->user();
        $comment = Comment::find($id);

        if ($auth_user->id == $comment->user_id) {
            $comment->delete();
            return response()->json('Success deleting', 200);
        } else {
            return response()->json(['error' => 'Something went wrong...'], 500);
        }
    }
}