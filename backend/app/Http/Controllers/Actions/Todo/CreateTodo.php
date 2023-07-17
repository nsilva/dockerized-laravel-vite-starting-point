<?php

namespace App\Http\Controllers\Actions\Todo;

use App\Http\Controllers\Actions\BaseAction;
use App\Models\Todo;
use App\Support\Enums\TodoStatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CreateTodo extends BaseAction
{
    public function create(Request $request): JsonResponse
    {
        $user = Auth::user();

        $parentTodoId = $request->input('parent_id', null);

        if ($parentTodoId) {
            $parentTodo = $user->todos()->find($parentTodoId);

            if (!$parentTodo) {
                return response()->json(['error' => 'Parent Todo not found'], 400);
            }
        }

        $data = $request->validated();
        $data['status'] = TodoStatusEnum::NOT_STARTED->value;
        $data['user_id'] = $user->id;
        $todo = new Todo($data);

        $user->todos()->save($todo);

        return $this->success(['todo' => $todo], [], '', 201);
    }
}
