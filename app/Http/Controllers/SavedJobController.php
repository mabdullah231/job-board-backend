<?php

namespace App\Http\Controllers;

use App\Models\SavedJob;
use Illuminate\Http\Request;

class SavedJobController extends Controller
{
    public function manageSavedJob(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:job_posts,id',
        ]);

        $savedJob = $request->id ? SavedJob::find($request->id) : new SavedJob;
        $savedJob->fill($request->all());
        $savedJob->save();

        return response()->json($savedJob, 201);
    }

    public function deleteSavedJob($id)
    {
        $savedJob = SavedJob::find($id);
        if ($savedJob) {
            $savedJob->delete();
            return response()->json(['message' => 'SavedJob deleted successfully']);
        }
        return response()->json(['message' => 'SavedJob not found'], 404);
    }

    public function getSavedJob($id)
    {
        $savedJob = SavedJob::find($id);
        return response()->json($savedJob);
    }

    public function getAllSavedJobs()
    {
        $savedJobs = SavedJob::all();
        return response()->json($savedJobs);
    }
}