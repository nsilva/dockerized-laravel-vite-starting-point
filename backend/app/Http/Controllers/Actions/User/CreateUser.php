<?php

namespace App\Http\Controllers\Actions\User;

use App\Http\Controllers\Actions\BaseAction;
use App\Models\User;
use Illuminate\Http\Request;

class CreateUser extends BaseAction
{
    public function create(Request $request)
    {
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
