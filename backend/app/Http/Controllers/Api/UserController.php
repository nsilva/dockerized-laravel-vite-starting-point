<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\HttpResponse;
use App\Models\User;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
    use HttpResponse;

    public function create(CreateUserRequest $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $responseData = [
            'message' => 'User created successfully.',
            'user' => $user,
        ];

        return $this->success($responseData, [], '', 201);
    }
}
