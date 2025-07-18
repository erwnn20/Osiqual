<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContractTypeRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'duration' => ['required', 'integer', 'min:0'],
            'monthly' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'duration.required' => 'La durée est requise.',
            'duration.integer' => 'La durée doit être un entier.',
            'duration.min' => 'La durée ne peut pas être négative.',

            'monthly.boolean' => 'Le champ mensuel doit être vrai ou faux.',
        ];

    }
}
