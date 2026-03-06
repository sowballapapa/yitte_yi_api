<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserPreferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'theme'              => ['sometimes', 'required', Rule::in(['light', 'dark', 'system'])],
            'language'           => ['sometimes', 'required', Rule::in(['fr', 'en'])],
            'timezone'           => ['sometimes', 'required', 'string', 'timezone'],
            'notification_delay' => ['sometimes', 'required', 'integer', 'min:1', 'max:999'],
            'notification_unit'  => ['sometimes', 'required', Rule::in(['minutes', 'hours', 'days'])],
        ];
    }

    public function messages(): array
    {
        return [
            'theme.in'                   => 'Le thème doit être "light", "dark" ou "system".',
            'language.in'                => 'La langue doit être "fr" ou "en".',
            'timezone.timezone'          => "Le fuseau horaire n'est pas valide.",
            'notification_delay.integer' => 'Le délai de notification doit être un entier.',
            'notification_delay.min'     => "Le délai de notification doit être d'au moins 1.",
            'notification_delay.max'     => 'Le délai de notification ne peut pas dépasser 999.',
            'notification_unit.in'       => 'L\'unité doit être "minutes", "hours" ou "days".',
        ];
    }
}
