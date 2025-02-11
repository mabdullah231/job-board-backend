<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function manageTag(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $tag = $request->id ? Tag::find($request->id) : new Tag;
        $tag->name = $request->name;
        $tag->save();

        return response()->json($tag, 201);
    }

    public function deleteTag($id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            $tag->delete();
            return response()->json(['message' => 'Tag deleted successfully']);
        }
        return response()->json(['message' => 'Tag not found'], 404);
    }

    public function getTag($id)
    {
        $tag = Tag::find($id);
        return response()->json($tag);
    }

    public function getAllTags()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }
}