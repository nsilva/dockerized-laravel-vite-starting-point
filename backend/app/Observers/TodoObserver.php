<?php

namespace App\Observers;

use App\Models\Todo;
use App\Support\Enums\TodoStatusEnum;

class TodoObserver
{
    /**
     * Handle the Todo "updated" event.
     *
     * @param Todo $todo
     *
     * @return void
     */
    public function updated(Todo $todo): void
    {
        // If parent complete, all child complete
        if ($todo->status == TodoStatusEnum::COMPLETE->value && $todo->parent_id == null) {
            $todo->subtasks()->update(['status' => TodoStatusEnum::COMPLETE->value]);
        }

        // If child in progress, parent in progress
        if ($todo->status == TodoStatusEnum::IN_PROGRESS->value && $todo->parent_id != null) {
            $todo->parent()->update(['status' => TodoStatusEnum::IN_PROGRESS->value]);
        }
    }
}
