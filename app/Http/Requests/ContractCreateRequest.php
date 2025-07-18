<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContractCreateRequest extends FormRequest
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
            'company' => ['required', 'exists:companies,id'],
            'type' => ['required', 'exists:contract_types,id'],
            'status' => ['required', 'exists:contract_statuses,id'],
            'start' => ['required', 'date', 'regex:/^\d{4}-\d{2}(-\d{2})?$/'],
            'end' => ['nullable', 'date', 'regex:/^\d{4}-\d{2}(-\d{2})?$/', 'after:start'],
        ];
    }

    public function messages(): array
    {
        return [
            'company.required' => 'La société est obligatoire.',
            'company.exists' => 'La société sélectionnée est invalide.',

            'type.required' => 'Le type de contrat est obligatoire.',
            'type.exists' => 'Le type de contrat sélectionné est invalide.',

            'status.required' => 'Le statut du contrat est obligatoire.',
            'status.exists' => 'Le statut sélectionné est invalide.',

            'start.required' => 'La date de début est obligatoire.',
            'start.date' => 'La date de début doit être une date valide.',
            'start.regex' => 'La date de début doit être au format YYYY-MM-DD ou YYYY-MM.',

            'end.date' => 'La date de fin doit être une date valide.',
            'end.regex' => 'La date de début doit être au format YYYY-MM-DD ou YYYY-MM.',
            'end.after' => 'La date de fin doit être postérieure à la date de début.',
        ];
    }

}
