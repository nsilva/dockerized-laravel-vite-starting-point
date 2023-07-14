<?php

use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    public function test_can_create_user()
    {
        $password = $this->faker->password();
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->post(route('api.user.create'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }
}
