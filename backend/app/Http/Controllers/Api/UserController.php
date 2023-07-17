<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Actions\User\CreateUser;
use App\Http\Controllers\Controller;
use App\Http\Traits\HttpResponse;
use App\Models\User;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
    use HttpResponse;

    public function create(CreateUserRequest $request, CreateUser $createUser)
    {
        return $createUser->create($request);
    }
}
