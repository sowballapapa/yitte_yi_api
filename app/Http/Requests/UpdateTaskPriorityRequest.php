<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskPriorityRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $id = $this->route('task_priority') ?? $this->route('id');

        return [
            'name'        => ['sometimes', 'required', 'string', 'max:100', Rule::unique('task_priorities', 'name')->ignore($id)],
            'color'       => ['sometimes', 'required', 'string', 'max:50'],
            'description' => ['sometimes', 'nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Custom validation messages in French.
     */
    public function messages(): array
    {
        return [
            'name.required'      => 'Le nom de la priorité est obligatoire.',
            'name.string'        => 'Le nom doit être une chaîne de caractères.',
            'name.max'           => 'Le nom ne peut pas dépasser 100 caractères.',
            'name.unique'        => 'Une priorité avec ce nom existe déjà.',
            'color.required'     => 'La couleur est obligatoire.',
            'color.string'       => 'La couleur doit être une chaîne de caractères.',
            'color.max'          => 'La couleur ne peut pas dépasser 50 caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max'    => 'La description ne peut pas dépasser 500 caractères.',
        ];
    }
}
