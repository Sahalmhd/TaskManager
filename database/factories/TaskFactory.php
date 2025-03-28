<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => $this->faker->date,
            'status' => $this->faker->randomElement(['Pending', 'in_progress', 'Completed']),
            'priority' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'user_id' => \App\Models\User::pluck('id')->random(),
        ];
    }
}
