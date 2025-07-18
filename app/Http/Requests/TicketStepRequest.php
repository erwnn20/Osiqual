<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TicketStepRequest extends FormRequest
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
            'step_technician' => ['required', 'exists:users,id'],
            'step_date' => ['required', 'date', 'date_format:Y-m-d\TH:i'],
            'step_description' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'step_technician.required' => 'Le technicien de l\'étape est obligatoire.',
            'step_technician.exists' => 'Le technicien sélectionné est invalide.',

            'step_date.required' => 'La date de l\'étape est obligatoire.',
            'step_date.date' => 'La date de l\'étape doit être une date valide.',
            'step_date.date_format' => 'La date de l\'étape doit être au format YYYY-MM-DD HH:MM:SS.',

            'step_description.string' => 'La description de l\'étape doit être une chaîne de caractères.',
        ];
    }
}
