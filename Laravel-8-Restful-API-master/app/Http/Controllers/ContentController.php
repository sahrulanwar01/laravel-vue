<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function index(Post $post)
    {
        $contents = $post->contents()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Content for Post',
            'data'    => $contents
        ], 200);
    }

    public function store(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $content = new Content([
            'content' => $request->content,
        ]);

        $post->contents()->save($content);

        return response()->json([
            'success' => true,
            'message' => 'Content Created',
            'data'    => $content
        ], 201);
    }

    public function show(Post $post, Content $content)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Content',
            'data'    => $content
        ], 200);
    }

    public function update(Request $request, Post $post, Content $content)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $content->content = $request->content;
        $content->save();

        return response()->json([
            'success' => true,
            'message' => 'Content Updated',
            'data'    => $content
        ], 200);
    }

    public function destroy(Post $post, Content $content)
    {
        $content->delete();

        return response()->json([
            'success' => true,
            'message' => 'Content Deleted',
        ], 200);
    }
}
