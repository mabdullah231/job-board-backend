<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class JobPostController extends Controller
{
    public function manageJobPost(Request $request)
    {
        $user = User::with('company')->find(Auth::id());
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'job_type' => 'required|in:Full-time,Part-time,Remote',
            'salary' => 'nullable|numeric',
            'deadline' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'city_id' => 'required|exists:cities,id',
            'tags' => 'array', // Ensure tags is an array
            'tags.*' => 'exists:tags,id',
            'skills' => 'array', // Ensure tags is an array
            'skills.*' => 'exists:skills,id',
        ]);

        $jobPost = $request->id ? JobPost::find($request->id) : new JobPost;
        $jobPost->fill($request->except('tags','skills'));
        $jobPost->company_id = $user->company->id;
        $jobPost->user_id = $user->id;
        $jobPost->save();
        if ($request->has('tags')) {
            $jobPost->tags()->sync($request->tags); // Assuming a many-to-many relationship
        }
        if ($request->has('tags')) {
            $jobPost->skills()->sync($request->skills); // Assuming a many-to-many relationship
        }
        return response()->json($user, 201);
    }

    public function deleteJobPost($id)
    {
        $jobPost = JobPost::find($id);
        if ($jobPost) {
            $jobPost->delete();
            return response()->json(['message' => 'Job post deleted successfully']);
        }
        return response()->json(['message' => 'Job post not found'], 404);
    }

    public function getJobPost($id)
    {
        $jobPost = JobPost::with('tags', 'skills', 'company', 'city', 'category')->find($id);
        return response()->json($jobPost);
    }

    public function getAllJobPosts()
    {
        $jobPosts = JobPost::all();
        $jobPosts = JobPost::with('tags','skills','company','city','category')->get(); // Eager load tags
        return response()->json($jobPosts);
    }

    public function getEmployerJobPosts()
    {
        $employer = Auth::id();
        $jobPosts = JobPost::where('user_id', $employer)->with('tags','skills')->get();
        return response()->json($jobPosts);
    }
}
