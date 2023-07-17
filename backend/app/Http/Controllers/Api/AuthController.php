<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Actions\Auth\GetAccessTokenAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HttpResponse;

    /**
     * Performs user login.
     *
     * @return LoginRequest
     */
    public function getAccessToken(LoginRequest $request, GetAccessTokenAction $tokenAction)
    {
        return $tokenAction->getToken($request);
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
