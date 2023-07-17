<?php

namespace App\Http\Controllers\Actions\Auth;

use App\Http\Controllers\Actions\BaseAction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class GetAccessTokenAction extends BaseAction
{
    public function getToken(Request $request): JsonResponse
    {
        try {
            $request->authenticate();

            $user = User::where('email', $request->email)
                ->first();

            $request->user()->tokens()->delete();

            return $this->success([
                'user' => $user,
                'access_token' => $user->createToken('')->plainTextToken
            ]);
        } catch (ValidationException $e) {
            return $this->error([], $e->getMessage(), 406);
        }
    }
}
