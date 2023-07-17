<?php

namespace App\Http\Requests;

use App\Rules\CanHaveTodos;
use Illuminate\Foundation\Http\FormRequest;

class CreateTodoRequest extends BaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'parent_id' => [
                'sometimes',
                'integer',
                'nullable',
                new CanHaveTodos()
            ]
        ];
    }
}
