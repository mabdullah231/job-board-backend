<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPost>
 */
class JobPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'job_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Remote']),
            'salary' => $this->faker->randomFloat(2, 1000, 10000),
            'deadline' => $this->faker->dateTimeBetween('now', '+1 year'),
            'category_id' => \App\Models\Category::factory(),
            'company_id' => \App\Models\Company::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
