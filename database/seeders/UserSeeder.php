<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Auth\Infrastructure\Models\User;
use Src\ToDoList\Infrastructure\Model\Task;

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
