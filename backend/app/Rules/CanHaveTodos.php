<?php

namespace App\Rules;

use App\Models\Todo;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class CanHaveTodos implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = Auth::user();

        $todo = Todo::find((int)$value);

        if (!$todo || $todo->user_id !== $user->id || $todo->parent_id != null) {
            $fail("Can't add subtask to this to-do");
        }
    }
}
