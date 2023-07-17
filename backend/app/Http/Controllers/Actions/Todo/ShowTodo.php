<?php

namespace App\Http\Controllers\Actions\Todo;

use App\Http\Controllers\Actions\BaseAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ShowTodo extends BaseAction
{
    public function show(): JsonResponse
    {
        $user = Auth::user();

        $todos = $user->todos()
            ->whereNull('parent_id')
            ->with('subtasks')
            ->get()
            ->all();

        return $this->success($todos);
    }
}
