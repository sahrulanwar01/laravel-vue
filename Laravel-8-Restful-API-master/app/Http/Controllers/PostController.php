<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('contents')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data'    => $posts  
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post = Post::create([
            'title' => $request->title,
        ]);

        if ($post) {
            $post->contents()->create([
                'content' => $request->content,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Created',
                'data'    => $post  
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post Failed to Save',
        ], 409);
    }

    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post->title = $request->title;
        $post->save();

        // Update content if exists
        if ($post->contents->isNotEmpty()) {
            $post->contents[0]->content = $request->content;
            $post->contents[0]->save();
        } else {
            // Create content if not exists
            $post->contents()->create([
                'content' => $request->content,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Post Updated',
            'data'    => $post  
        ], 200);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post) {
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post Deleted',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }
    public function show($id)
{
    //find post by ID
    $post = Post::findOrFail($id);

    //make response JSON
    return response()->json([
        'success' => true,
        'message' => 'Detail Data Post',
        'data'    => $post 
    ], 200);
}
    
}
