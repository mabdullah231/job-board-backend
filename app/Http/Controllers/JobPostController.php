<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    public function manageJobPost(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'job_type' => 'required|in:Full-time,Part-time,Remote',
            'salary' => 'nullable|numeric',
            'deadline' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'required|exists:companies,id',
            'user_id' => 'required|exists:users,id',
            'city_id' => 'required|exists:cities,id',
        ]);

        $jobPost = $request->id ? JobPost::find($request->id) : new JobPost;
        $jobPost->fill($request->all());
        $jobPost->save();

        return response()->json($jobPost, 201);
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
        $jobPost = JobPost::find($id);
        return response()->json($jobPost);
    }

    public function getAllJobPosts()
    {
        $jobPosts = JobPost::all();
        return response()->json($jobPosts);
    }
}