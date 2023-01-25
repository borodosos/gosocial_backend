<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        // $tags = ['IT', 'Humor', 'Science'];
        // foreach ($tags as $tag) {
        //     Tag::create([
        //         'tag_text'  =>  $tag,
        //     ]);
        // }

        // $posts = Post::create([
        //     'title'  =>  'Home Brixton Faux Leather Armchair',
        //     'text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.
        //                Aspernatur adipisci aut ad, tenetur deleniti animi saepe
        //                nostrum voluptatem distinctio neque accusantium pariatur
        //                vero doloribus at praesentium quasi ex porro! Corrupti.',
        //     'image' => '111'
        // ]);

        // $posts = Post::all();
        return response()->json('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->json('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return response()->json('store');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return response()->json('show');
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