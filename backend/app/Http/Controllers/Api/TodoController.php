<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use App\Support\Enums\TodoStatusEnum;
use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $todos = $user->todos()->get();

        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTodoRequest $request)
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

        return response()->json($todo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $todo = $user->todos()->find($id);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, string $id)
    {
        $user = Auth::user();
        $todo = $user->todos()->find($id);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        $todo->update($request->validated());

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $todo = $user->todos()->find($id);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        $todo->delete();

        return response()->json(null, 204);
    }
}
