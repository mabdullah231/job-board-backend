<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function manageJobApplication(Request $request)
    {
        $request->validate([
            'cover_letter' => 'nullable|string',
            'status' => 'nullable|in:pending,accepted,rejected',
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:job_posts,id',
        ]);

        $jobApplication = $request->id ? JobApplication::find($request->id) : new JobApplication;
        $jobApplication->fill($request->all());
        $jobApplication->save();

        return response()->json($jobApplication, 201);
    }

    public function deleteJobApplication($id)
    {
        $jobApplication = JobApplication::find($id);
        if ($jobApplication) {
            $jobApplication->delete();
            return response()->json(['message' => 'Job application deleted successfully']);
        }
        return response()->json(['message' => 'Job application not found'], 404);
    }

    public function getJobApplication($id)
    {
        $jobApplication = JobApplication::find($id);
        return response()->json($jobApplication);
    }

    public function getAllJobApplications()
    {
        $jobApplications = JobApplication::all();
        return response()->json($jobApplications);
    }
}