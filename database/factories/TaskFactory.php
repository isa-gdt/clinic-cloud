<?php

declare(strict_types=1);

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Auth\Infraestructure\Models\Task;
use Src\Auth\Infraestructure\Models\User;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'created_by' => User::factory(),
            'assigned_to' => User::factory(),
            'text' => fake()->text(),
            'status' => fake()->randomElement(['pending', 'completed', 'in_progress']),
        ];
    }
}
