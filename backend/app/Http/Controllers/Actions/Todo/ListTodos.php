<?php

namespace App\Http\Controllers\Actions\Todo;

use App\Http\Controllers\Actions\BaseAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ListTodos extends BaseAction
{
    public function listTodos(): JsonResponse
    {
        $user = Auth::user();

        $todos = $user->todos()
            ->whereNull('parent_id')
            ->with('subtasks')
            ->orderBy('created_at', 'desc')
            ->get()
            ->all();

        return $this->success($todos);
    }
}
