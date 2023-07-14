<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    use HttpResponse;

    /**
     * Performs user login.
     *
     * @return LoginRequest
     */
    public function getAccessToken(LoginRequest $request)
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

    /**
     * Deletes access token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAccessToken(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->success([], [], '', 204);
    }
}
