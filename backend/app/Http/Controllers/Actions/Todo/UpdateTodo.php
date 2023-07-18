<?php

namespace App\Http\Controllers\Actions\Todo;

use App\Http\Controllers\Actions\BaseAction;
use App\Models\Todo;
use App\Support\Enums\TodoStatusEnum;
use Carbon\Carbon;
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

        $data = $request->validated();

        if (isset($data['status'])
            && $data['status'] == TodoStatusEnum::IN_PROGRESS->value
            && $todo->status != TodoStatusEnum::IN_PROGRESS->value) {
            $data['in_progress_since'] = Carbon::now()->toDateTimeString();
        }

        $todo->update($data);

        return $this->success(['todo' => $todo->loadMissing('subtasks')]);
    }
}
