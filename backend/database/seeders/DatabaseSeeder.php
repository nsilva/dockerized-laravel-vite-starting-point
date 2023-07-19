<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Todo;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        Todo::create([
            'title' => 'Call Mike',
            'user_id' => $user->id
        ]);

        $parentTodo = Todo::create([
            'title' => 'Buy groceries',
            'user_id' => $user->id
        ]);

        Todo::create([
            'title' => 'Buy milk',
            'parent_id' => $parentTodo->id,
            'user_id' => $user->id
        ]);

        Todo::create([
            'title' => 'Buy avocado',
            'parent_id' => $parentTodo->id,
            'user_id' => $user->id
        ]);
    }
}
