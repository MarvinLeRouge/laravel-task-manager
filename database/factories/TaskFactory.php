<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'title'       => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status'      => fake()->randomElement(['todo', 'in_progress', 'done']),
            'priority'    => fake()->randomElement(['low', 'medium', 'high']),
            'due_date'    => fake()->dateTimeBetween('now', '+1 year'),
        ];
    }
}
