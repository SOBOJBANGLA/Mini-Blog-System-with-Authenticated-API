<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // List all categories
    public function index()
    {
        return response()->json(Category::all());
    }

    // Create a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return response()->json($category, 201);
    }

    // Update an existing category
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return response()->json($category);
    }

    // Delete a category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted']);
    }
} 