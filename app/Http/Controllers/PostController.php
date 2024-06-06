<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->get();
        return response()->json($posts);
    }

    public function store(StorePostRequest $request)
    {

        try{

        $post = $request->user()->posts()->create($request->all());
        Log::info('Post created', ['post' => $post]);
        return response()->json($post, 201);

        }

        catch (\Exception $e) {

            return response()->json(['error' =>$e->getMessage()], 500);
        }
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {

        try{
            $post->update($request->all());
            Log::info('Post updated', ['post' => $post]);

            return response()->json($post);
        }
        catch (\Exception $e) {

            return response()->json(['error' =>$e->getMessage()], 500);
        }

    }

    public function destroy(Post $post)
    {
        $post->delete();
        Log::info('Post deleted', ['post' => $post]);

        return response()->json(null, 204);
    }
}
