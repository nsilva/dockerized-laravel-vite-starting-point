<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Todo;
use App\Support\Enums\TodoStatusEnum;

class TodoControllerTest extends TestCase
{
    public function test_can_get_all_todos()
    {
        $user = User::factory()->create();
        Todo::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('api.todos.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(3);

        // Test returns list of parent only and subtasks are included as children
        $parent = Todo::factory()->create(['user_id' => $user->id]);
        Todo::factory()->create(['user_id' => $user->id, 'parent_id' => $parent->id]);

        $response = $this->actingAs($user)->get(route('api.todos.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(4);
    }

    public function test_can_get_todo_by_id()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('api.todos.show', $todo->id));

        $response->assertStatus(200);
        $response->assertJson($todo->toArray());
    }

    public function test_can_create_todo()
    {
        $user = User::factory()->create();

        $data = [
            'title' => 'Sample Todo',
        ];

        $response = $this->actingAs($user)->post(route('api.todos.store'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('todos', $data + ['user_id' => $user->id]);
    }

    public function test_can_create_todo_with_parent()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        $todo = Todo::factory()->create(['user_id' => $user->id]);
        $data = [
            'title' => 'Sample Todo',
            'parent_id' => 1000
        ];

        // Parent does *not* exist
        $response = $this->actingAs($anotherUser)->post(route('api.todos.store'), $data);
        $response->assertStatus(400);
        $this->assertDatabaseMissing('todos', $data + ['user_id' => $user->id]);

        $data['parent_id'] = $todo->id;
        // Parent todo does *not* belong to the user
        $response = $this->actingAs($anotherUser)->post(route('api.todos.store'), $data);
        $response->assertStatus(400);
        $this->assertDatabaseMissing('todos', $data + ['user_id' => $user->id]);

        // Parent todo belongs to the user
        $response = $this->actingAs($user)->post(route('api.todos.store'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('todos', $data + ['user_id' => $user->id]);
    }

    public function test_can_update_todo()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $data = [
            'title' => 'Updated Todo',
            'status' => TodoStatusEnum::IN_PROGRESS->value
        ];

        // Todo does not belong to user
        $response = $this->actingAs($anotherUser)->put(route('api.todos.update', $todo->id), $data);
        $response->assertStatus(404);

        // Todo belongs to user
        $response = $this->actingAs($user)->put(route('api.todos.update', $todo->id), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('todos', $data + ['user_id' => $user->id]);
    }

    public function test_can_delete_todo()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        // Todo does not belong to user
        $response = $this->actingAs($anotherUser)->delete(route('api.todos.destroy', $todo->id));
        $response->assertStatus(404);

        $response = $this->actingAs($user)->delete(route('api.todos.destroy', $todo->id));
        $response->assertStatus(204);
        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }
}

