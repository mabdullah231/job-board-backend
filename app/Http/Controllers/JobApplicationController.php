<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\ApplicationFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\JobApplicationSubmitted;
use Illuminate\Support\Facades\Mail;

use App\Mail\JobApplicationStatusUpdated;


class JobApplicationController extends Controller
{
    public function manageJobApplication(Request $request)
    {
        $request->validate([
            'cover_letter' => 'nullable|string',
            'job_id' => 'required|exists:job_posts,id',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Only accept CV files
        ]);

        $userId = Auth::id();
        $jobId = $request->job_id;

        // Check if the user has already applied for this job
        if (!$request->id && JobApplication::where('job_id', $jobId)->where('user_id', $userId)->exists()) {
            return response()->json(['error' => 'You have already applied for this job'], 400);
        }

        $jobApplication = $request->id ? JobApplication::find($request->id) : new JobApplication;

        if (!$jobApplication) {
            return response()->json(['error' => 'Job application not found'], 404);
        }

        $jobApplication->fill($request->except(['attachment']));
        $jobApplication->user_id = $userId; // Set user ID from auth
        $jobApplication->save(); // Save job application first to get its ID

        // Handle file upload and store in application_files table
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cvs'), $filename);

            // Store in ApplicationFile model
            ApplicationFile::create([
                'file_path' => 'uploads/cvs/' . $filename,
                'application_id' => $jobApplication->id,
            ]);
        }
        $job = $jobApplication->job;
        $employerEmail = $job->user->email;
        $applicantEmail = Auth::user()->email;
    
        Mail::to($employerEmail)->send(new JobApplicationSubmitted($jobApplication));
        Mail::to($applicantEmail)->send(new JobApplicationSubmitted($jobApplication));

        return response()->json($jobApplication, 201);
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $jobApplication = JobApplication::find($id);

        if (!$jobApplication) {
            return response()->json(['error' => 'Job application not found'], 404);
        }

        // Update the status
        $jobApplication->status = $request->status;
        $jobApplication->save();
        Mail::to($jobApplication->user->email)->send(new JobApplicationStatusUpdated($jobApplication));

        return response()->json([
            'message' => "Application has been {$request->status} successfully",
            'application' => $jobApplication
        ], 200);
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

    public function getEmployerJobApplications()
    {
        $userId = Auth::id();

        // Fetch job applications where the job is posted by the employer (auth user)
        $jobApplications = JobApplication::whereHas('job', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['job', 'user'])->get();

        return response()->json($jobApplications);
    }

    public function getUserJobApplications()
    {
        $userId = Auth::id();
    
        // Fetch job applications where the user_id is equal to the logged-in user
        $jobApplications = JobApplication::where('user_id', $userId)
            ->with(['job', 'job.company', 'user']) // Include company details
            ->get();
    
        return response()->json($jobApplications);
    }

    public function getSingleEmployerJobApplication($id)
    {
        // Fetch job application along with job details and applicant (user) details
        $jobApplication = JobApplication::with(['job', 'user', 'file'])->find($id);

        if (!$jobApplication) {
            return response()->json(['error' => 'Job application not found'], 404);
        }

        return response()->json($jobApplication);
    }
}
