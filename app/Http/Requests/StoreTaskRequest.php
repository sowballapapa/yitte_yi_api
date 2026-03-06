<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
        return [
            'title'            => ['required', 'string', 'max:255'],
            'content'          => ['nullable', 'string'],
            'start_date'       => ['required', 'date', 'date_format:Y-m-d'],
            'start_time'       => ['required', 'date_format:H:i:s'],
            'due_datetime'     => ['required', 'date', 'after_or_equal:start_date'],
            'is_completed'     => ['boolean'],
            'end_time'         => ['nullable', 'date_format:H:i:s'],
            'end_date'         => ['nullable', 'date', 'date_format:Y-m-d', 'after_or_equal:start_date'],
            'task_priority_id' => ['required', 'integer', 'exists:task_priorities,id'],
        ];
    }

    /**
     * Custom validation messages in French.
     */
    public function messages(): array
    {
        return [
            'title.required'            => 'Le titre de la tâche est obligatoire.',
            'title.string'              => 'Le titre doit être une chaîne de caractères.',
            'title.max'                 => 'Le titre ne peut pas dépasser 255 caractères.',
            'content.string'            => 'Le contenu doit être une chaîne de caractères.',
            'start_date.required'       => 'La date de début est obligatoire.',
            'start_date.date'           => 'La date de début doit être une date valide.',
            'start_date.date_format'    => 'La date de début doit être au format YYYY-MM-DD.',
            'start_time.required'       => 'L\'heure de début est obligatoire.',
            'start_time.date_format'    => 'L\'heure de début doit être au format HH:MM:SS.',
            'due_datetime.required'     => 'La date et heure d\'échéance sont obligatoires.',
            'due_datetime.date'         => 'La date d\'échéance doit être une date valide.',
            'due_datetime.after_or_equal' => 'La date d\'échéance doit être postérieure ou égale à la date de début.',
            'is_completed.boolean'      => 'Le statut de complétion doit être vrai ou faux.',
            'end_time.date_format'      => 'L\'heure de fin doit être au format HH:MM:SS.',
            'end_date.date'             => 'La date de fin doit être une date valide.',
            'end_date.date_format'      => 'La date de fin doit être au format YYYY-MM-DD.',
            'end_date.after_or_equal'   => 'La date de fin doit être postérieure ou égale à la date de début.',
            'task_priority_id.required' => 'La priorité de la tâche est obligatoire.',
            'task_priority_id.integer'  => 'La priorité doit être un identifiant valide.',
            'task_priority_id.exists'   => 'La priorité sélectionnée n\'existe pas.',
        ];
    }
}
