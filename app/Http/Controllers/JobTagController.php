<?php

namespace App\Http\Controllers;

use App\Models\JobTag;
use Illuminate\Http\Request;

class JobTagController extends Controller
{
    public function manageJobTag(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:job_posts,id',
            'tag_id' => 'required|exists:tags,id',
        ]);

        $jobTag = $request->id ? JobTag::find($request->id) : new JobTag;
        $jobTag->job_id = $request->job_id;
        $jobTag->tag_id = $request->tag_id;
        $jobTag->save();

        return response()->json($jobTag, 201);
    }

    public function deleteJobTag($id)
    {
        $jobTag = JobTag::find($id);
        if ($jobTag) {
            $jobTag->delete();
            return response()->json(['message' => 'JobTag deleted successfully']);
        }
        return response()->json(['message' => 'JobTag not found'], 404);
    }

    public function getJobTag($id)
    {
        $jobTag = JobTag::find($id);
        return response()->json($jobTag);
    }

    public function getAllJobTags()
    {
        $jobTags = JobTag::all();
        return response()->json($jobTags);
    }
}