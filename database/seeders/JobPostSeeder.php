<?php

namespace Database\Seeders;

use App\Models\JobPost;
use Illuminate\Database\Seeder;

class JobPostSeeder extends Seeder
{
    public function run()
    {
        JobPost::factory()->count(20)->create(); // Create 20 job posts
    }
}
