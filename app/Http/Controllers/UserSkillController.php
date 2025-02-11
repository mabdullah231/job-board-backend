<?php

namespace App\Http\Controllers;

use App\Models\UserSkill;
use Illuminate\Http\Request;

class UserSkillController extends Controller
{
    public function manageUserSkill(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'skill_id' => 'required|exists:skills,id',
            'proficiency' => 'nullable|integer',
        ]);

        $userSkill = $request->id ? UserSkill::find($request->id) : new UserSkill;
        $userSkill->fill($request->all());
        $userSkill->save();

        return response()->json($userSkill, 201);
    }

    public function deleteUserSkill($id)
    {
        $userSkill = UserSkill::find($id);
        if ($userSkill) {
            $userSkill->delete();
            return response()->json(['message' => 'UserSkill deleted successfully']);
        }
        return response()->json(['message' => 'UserSkill not found'], 404);
    }

    public function getUserSkill($id)
    {
        $userSkill = UserSkill::find($id);
        return response()->json($userSkill);
    }

    public function getAllUserSkills()
    {
        $userSkills = UserSkill::all();
        return response()->json($userSkills);
    }
}