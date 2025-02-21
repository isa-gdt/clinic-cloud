<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Auth\Infraestructure\Models\Task;
use Src\Auth\Infraestructure\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->has(Task::factory(3), 'tasksCreated')
            ->has(Task::factory(3), 'tasksAssigned')
            ->create();

        User::factory()
            ->create([
            'name' => 'Chandler Bing',
            'email' => 'chandler@friends.com',
        ]);
    }
}
