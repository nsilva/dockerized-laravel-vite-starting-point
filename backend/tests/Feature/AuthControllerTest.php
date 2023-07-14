<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    public function test_can_login_user()
    {
        $password = 'password123';

        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => Hash::make($password),
        ]);

        $data = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->post(route('api.auth.login'), $data);

        $response->assertStatus(200);
        $this->assertAuthenticated();
    }

    public function test_invalid_credentials_return_error()
    {
        $data = [
            'email' => "invalid@mail.com",
            'password' => "fakePa22w0rd",
        ];

        $response = $this->post(route('api.auth.login'), $data);

        $response->assertStatus(406);
    }

    public function test_can_logout_user()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('api.auth.logout'));

        $response->assertStatus(204);
    }
}
