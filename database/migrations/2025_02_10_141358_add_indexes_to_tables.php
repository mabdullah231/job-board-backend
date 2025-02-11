<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->index('user_type');
            $table->index('code');
        });

        // Companies Table
        Schema::table('companies', function (Blueprint $table) {
            $table->index('user_id');
        });

        // Categories Table
        Schema::table('categories', function (Blueprint $table) {
            $table->index('name');
        });

        // Job Posts Table
        Schema::table('job_posts', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('company_id');
            $table->index('user_id');
            $table->index('city_id');
            $table->index('job_type');
            $table->index('salary');
            $table->index('deadline');
        });

        // Skills Table
        Schema::table('skills', function (Blueprint $table) {
            $table->index('name');
        });

        // Job Skills Table
        Schema::table('job_skills', function (Blueprint $table) {
            $table->index('job_id');
            $table->index('skill_id');
        });

        // User Skills Table
        Schema::table('user_skills', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('skill_id');
            $table->index('proficiency'); // New proficiency column
        });

        // Job Applications Table
        Schema::table('job_applications', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('job_id');
            $table->index('status');
        });

        // Application Files Table
        Schema::table('application_files', function (Blueprint $table) {
            $table->index('application_id');
        });

        // Notifications Table
        Schema::table('notifications', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('is_read');
        });

        // Saved Jobs Table
        Schema::table('saved_jobs', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('job_id');
        });

        // Tags Table
        Schema::table('tags', function (Blueprint $table) {
            $table->index('name');
        });

        // Job Tags Table
        Schema::table('job_tags', function (Blueprint $table) {
            $table->index('job_id');
            $table->index('tag_id');
        });

        // Cities Table
        Schema::table('cities', function (Blueprint $table) {
            $table->unique('city'); // Ensures no duplicate city names
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['user_type']);
            $table->dropIndex(['code']);
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });

        Schema::table('job_posts', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['company_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['city_id']);
            $table->dropIndex(['job_type']);
            $table->dropIndex(['salary']);
            $table->dropIndex(['deadline']);
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });

        Schema::table('job_skills', function (Blueprint $table) {
            $table->dropIndex(['job_id']);
            $table->dropIndex(['skill_id']);
        });

        Schema::table('user_skills', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['skill_id']);
            $table->dropIndex(['proficiency']);
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['job_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('application_files', function (Blueprint $table) {
            $table->dropIndex(['application_id']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['is_read']);
        });

        Schema::table('saved_jobs', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['job_id']);
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });

        Schema::table('job_tags', function (Blueprint $table) {
            $table->dropIndex(['job_id']);
            $table->dropIndex(['tag_id']);
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropUnique(['city']);
        });
    }
};
