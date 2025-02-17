<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    // Get details of a single user with associated company
    public function getUser($id)
    {
        $user = User::with('company')->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    // Get all users with associated companies
    public function getAllUsers()
    {
        $currentUserId = Auth::id();

        // Retrieve all users except the current authenticated user
        $users = User::with('company')->where('id', '!=', $currentUserId)->get();

        // Return the users as a JSON response
        return response()->json($users);
    }

    // Activate or deactivate a user
    public function toggleUserStatus($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json(['message' => 'User status updated', 'is_active' => $user->is_active]);
    }

    // Delete a user
    // public function deleteUser($id)
    // {
    //     $user = User::find($id);
    //     if (!$user) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }

    //     $user->delete();
    //     return response()->json(['message' => 'User deleted successfully']);
    // }
}
