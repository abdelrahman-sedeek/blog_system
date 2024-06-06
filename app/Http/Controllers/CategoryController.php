<?php

namespace App\Http\Controllers;
use App\Models\category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($request->all());
        Log::info('Category created', ['category' => $category]);

        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);

        $category->update($request->all());
        Log::info('Category updated', ['category' => $category]);

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        Log::info('Category deleted', ['category' => $category]);

        return response()->json(null, 204);
    }
}
