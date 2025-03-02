<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\JobPost;
use App\Models\JobApplication;
use App\Models\User;
use App\Models\Tag;
use App\Models\Skill;
use App\Models\Category;

class StatsController extends Controller
{
    public function employerStats()
    {
        $userId = Auth::id();

        // Get the company where the authenticated user is the owner
        $company = Company::where('user_id', $userId)->first();

        // Get all job posts created by the authenticated user
        $jobPosts = JobPost::where('user_id', $userId)->get();

        // Get job applications related to job posts created by the authenticated user
        $jobApplications = JobApplication::whereHas('job', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        // Count job posts
        $jobPostCount = $jobPosts->count();

        // Count job applications
        $jobApplicationCount = $jobApplications->count();

        // Count applications by status
        $applicationCounts = [
            'accepted' => $jobApplications->where('status', 'accepted')->count(),
            'rejected' => $jobApplications->where('status', 'rejected')->count(),
            'pending' => $jobApplications->where('status', 'pending')->count(),
        ];

        return response()->json([
            'company' => $company,
            'job_post_count' => $jobPostCount,
            'job_application_count' => $jobApplicationCount,
            'application_counts' => $applicationCounts,
        ]);
    }

    public function adminStats()
    {
        // Count all users
        $totalUsers = User::count();

        // Count users based on user_type distinction
        $userTypes = [
            'employer' => User::where('user_type', 1)->count(),
            'job_seeker' => User::where('user_type', 2)->count(),
        ];

        // Count all companies
        $companyCount = Company::count();

        // Count all job posts
        $jobPostCount = JobPost::count();

        // Count all job applications
        $jobApplicationCount = JobApplication::count();

        // Count applications by status
        $applicationCounts = [
            'accepted' => JobApplication::where('status', 'accepted')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
            'pending' => JobApplication::where('status', 'pending')->count(),
        ];

        // Count total tags, skills, and categories
        $tagCount = Tag::count();
        $skillCount = Skill::count();
        $categoryCount = Category::count();

        return response()->json([
            'total_users' => $totalUsers,
            'user_types' => $userTypes,
            'total_companies' => $companyCount,
            'total_job_posts' => $jobPostCount,
            'total_job_applications' => $jobApplicationCount,
            'application_counts' => $applicationCounts,
            'total_tags' => $tagCount,
            'total_skills' => $skillCount,
            'total_categories' => $categoryCount,
        ]);
    }
}
