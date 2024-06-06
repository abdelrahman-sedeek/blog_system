<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = $request->user()->posts()->create($request->all());
        Log::info('Post created', ['post' => $post]);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $post->update($request->all());
        Log::info('Post updated', ['post' => $post]);

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        Log::info('Post deleted', ['post' => $post]);

        return response()->json(null, 204);
    }
}
