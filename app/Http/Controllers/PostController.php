<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $posts =  $user->Posts()->get();
        return response()->json(['posts' => $posts]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = new Post([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ]);

        $post->save();
        return response()->json(['post' => $post], 201);
    }

    public function show($id)
    {
        $user = Auth::user();
        $post = $user->posts()->findOrFail($id);
        return response()->json(['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return response()->json(['post' => $post]);
    }

    public function destroy($id)
    {
        $post = post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
