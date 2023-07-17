<?php

namespace App\Http\Controllers\Actions\Todo;

use App\Http\Controllers\Actions\BaseAction;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ShowTodo extends BaseAction
{
    public function show(Todo $todo): JsonResponse
    {
        if (!Auth::user()->can('view', $todo)) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        return response()->json($todo);
    }
}
