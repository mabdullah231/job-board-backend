<?php

use App\Http\Controllers\ApplicationFileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\JobTagController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserSkillController;



use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/resend-email', [AuthController::class, 'resendEmail']);
    Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/verify-forgot-email', [AuthController::class, 'verifyForgotEmail']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Protected Routes (Require Authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('company')->group(function () {
    Route::post('/manage', [CompanyController::class, 'manageCompany']);
    Route::delete('/delete/{id}', [CompanyController::class, 'deleteCompany']);
    Route::get('/get/{id}', [CompanyController::class, 'getCompany']);
    Route::get('/all', [CompanyController::class, 'getAllCompanies']);
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    Route::prefix('category')->group(function () {
        Route::post('/manage', [CategoryController::class, 'manageCategory']);
        Route::delete('/delete/{id}', [CategoryController::class, 'deleteCategory']);
        Route::get('/get/{id}', [CategoryController::class, 'getCategory']);
        Route::get('/all', [CategoryController::class, 'getAllCategories']);
    });

});

// JobPost Routes
Route::prefix('jobpost')->group(function () {
    Route::post('/manage', [JobPostController::class, 'manageJobPost']);
    Route::delete('/delete/{id}', [JobPostController::class, 'deleteJobPost']);
    Route::get('/get/{id}', [JobPostController::class, 'getJobPost']);
    Route::get('/all', [JobPostController::class, 'getAllJobPosts']);
});

// Skill Routes
Route::prefix('skill')->group(function () {
    Route::post('/manage', [SkillController::class, 'manageSkill']);
    Route::delete('/delete/{id}', [SkillController::class, 'deleteSkill']);
    Route::get('/get/{id}', [SkillController::class, 'getSkill']);
    Route::get('/all', [SkillController::class, 'getAllSkills']);
});

// JobApplication Routes
Route::prefix('jobapplication')->group(function () {
    Route::post('/manage', [JobApplicationController::class, 'manageJobApplication']);
    Route::delete('/delete/{id}', [JobApplicationController::class, 'deleteJobApplication']);
    Route::get('/get/{id}', [JobApplicationController::class, 'getJobApplication']);
    Route::get('/all', [JobApplicationController::class, 'getAllJobApplications']);
});

Route::prefix('tag')->group(function () {
    Route::post('/manage', [TagController::class, 'manageTag']);
    Route::delete('/delete/{id}', [TagController::class, 'deleteTag']);
    Route::get('/get/{id}', [TagController::class, 'getTag']);
    Route::get('/all', [TagController::class, 'getAllTags']);
});

// City Routes
Route::prefix('city')->group(function () {
    Route::post('/manage', [CityController::class, 'manageCity']);
    Route::delete('/delete/{id}', [CityController::class, 'deleteCity']);
    Route::get('/get/{id}', [CityController::class, 'getCity']);
    Route::get('/all', [CityController::class, 'getAllCities']);
});

// JobTag Routes
Route::prefix('jobtag')->group(function () {
    Route::post('/manage', [JobTagController::class, 'manageJobTag']);
    Route::delete('/delete/{id}', [JobTagController::class, 'deleteJobTag']);
    Route::get('/get/{id}', [JobTagController::class, 'getJobTag']);
    Route::get('/all', [JobTagController::class, 'getAllJobTags']);
});

// UserSkill Routes
Route::prefix('userskill')->group(function () {
    Route::post('/manage', [UserSkillController::class, 'manageUserSkill']);
    Route::delete('/delete/{id}', [UserSkillController::class, 'deleteUserSkill']);
    Route::get('/get/{id}', [UserSkillController::class, 'getUserSkill']);
    Route::get('/all', [UserSkillController::class, 'getAllUserSkills']);
});

// Notification Routes
Route::prefix('notification')->group(function () {
    Route::post('/manage', [NotificationController::class, 'manageNotification']);
    Route::delete('/delete/{id}', [NotificationController::class, 'deleteNotification']);
    Route::get('/get/{id}', [NotificationController::class, 'getNotification']);
    Route::get('/all', [NotificationController::class, 'getAllNotifications']);
});

// SavedJob Routes
Route::prefix('savedjob')->group(function () {
    Route::post('/manage', [SavedJobController::class, 'manageSavedJob']);
    Route::delete('/delete/{id}', [SavedJobController::class, 'deleteSavedJob']);
    Route::get('/get/{id}', [SavedJobController::class, 'getSavedJob']);
    Route::get('/all', [SavedJobController::class, 'getAllSavedJobs']);
});

// ApplicationFile Routes
Route::prefix('applicationfile')->group(function () {
    Route::post('/manage', [ApplicationFileController::class, 'manageApplicationFile']);
    Route::delete('/delete/{id}', [ApplicationFileController::class, 'deleteApplicationFile']);
    Route::get('/get/{id}', [ApplicationFileController::class, 'getApplicationFile']);
    Route::get('/all', [ApplicationFileController::class, 'getAllApplicationFiles']);
});

