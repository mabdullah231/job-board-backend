<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function manageCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $category = $request->id ? Category::find($request->id) : new Category;
        $category->name = $request->name;
        $category->save();

        return response()->json($category, 201);
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully']);
        }
        return response()->json(['message' => 'Category not found'], 404);
    }

    public function getCategory($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function getAllCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
}
