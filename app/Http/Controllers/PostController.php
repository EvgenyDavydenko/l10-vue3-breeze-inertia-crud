<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->get();
        return Inertia::render('Posts/Index', ['posts' => $posts]);
    }

    /** 
     * Write code on Method 
     * 
     * @return response() 
     */
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    /** 
     * Show the form for creating a new resource. 
     * 
     * @return Response 
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
        ])->validate();

        $post = new Post();
        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        //Post::create($request->all());
        return redirect()->route('posts.index');
    }

    /** 
     * Write code on Method 
     * 
     * @return response() 
     */
    public function edit(Post $post)
    {
        return Inertia::render('Posts/Edit', [
            'post' => $post
        ]);
    }

    /** 
     * Show the form for creating a new resource. 
     * 
     * @return Response 
     */
    public function update($id, Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
        ])->validate();

        Post::find($id)->update($request->all());
        return redirect()->route('posts.index');
    }

    /** 
     * Show the form for creating a new resource. 
     * 
     * @return Response 
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return redirect()->route('posts.index');
    }
}
