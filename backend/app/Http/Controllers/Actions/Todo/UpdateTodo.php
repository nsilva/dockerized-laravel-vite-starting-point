<?php

namespace App\Http\Controllers\Actions\Todo;

use App\Http\Controllers\Actions\BaseAction;
use App\Models\Todo;
use App\Support\Enums\TodoStatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UpdateTodo extends BaseAction
{
    public function update(Request $request, Todo $todo): JsonResponse
    {
        $user = Auth::user();

        if (!$user->can('update', $todo)) {
            return $this->error([], "Can't update this to-do", 404);
        }

        $todo->update($request->validated());

        return $this->success(['todo' => $todo->loadMissing('subtasks')]);
    }
}
