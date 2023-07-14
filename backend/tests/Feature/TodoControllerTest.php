<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Todo;

class TodoControllerTest extends TestCase
{
    public function test_can_get_all_todos()
    {
        $user = User::factory()->create();
        Todo::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('todos.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_can_get_todo_by_id()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('todos.show', $todo->id));

        $response->assertStatus(200);
        $response->assertJson($todo->toArray());
    }

    public function test_can_create_todo()
    {
        $user = User::factory()->create();

        $data = [
            'title' => 'Sample Todo',
            'description' => 'This is a sample todo.',
        ];

        $response = $this->actingAs($user)->post(route('todos.create'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('todos', $data + ['user_id' => $user->id]);
    }

    public function test_can_update_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $data = [
            'title' => 'Updated Todo',
            'description' => 'This is an updated todo.',
        ];

        $response = $this->actingAs($user)->put(route('todos.update', $todo->id), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('todos', $data + ['user_id' => $user->id]);
    }

    public function test_can_delete_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('todos.destroy', $todo->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }
}

