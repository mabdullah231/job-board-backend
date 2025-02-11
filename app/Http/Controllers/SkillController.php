<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function manageSkill(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $skill = $request->id ? Skill::find($request->id) : new Skill;
        $skill->name = $request->name;
        $skill->save();

        return response()->json($skill, 201);
    }

    public function deleteSkill($id)
    {
        $skill = Skill::find($id);
        if ($skill) {
            $skill->delete();
            return response()->json(['message' => 'Skill deleted successfully']);
        }
        return response()->json(['message' => 'Skill not found'], 404);
    }

    public function getSkill($id)
    {
        $skill = Skill::find($id);
        return response()->json($skill);
    }

    public function getAllSkills()
    {
        $skills = Skill::all();
        return response()->json($skills);
    }
}