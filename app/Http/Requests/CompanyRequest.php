<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'address' => ['required', 'string', 'max:255'],
            'zipcode' => ['nullable', 'integer', 'digits_between:4,10'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'size:2'],
            'siret' => ['required',  'regex:/^\d{3} \d{3} \d{3} \d{5}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de l\'entreprise est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne peut pas dépasser :max caractères.',

            'address.required' => 'L\'adresse est obligatoire.',
            'address.string' => 'L\'adresse doit être une chaîne de caractères.',
            'address.max' => 'L\'adresse ne peut pas dépasser :max caractères.',

            'zipcode.integer' => 'Le code postal doit être un nombre.',
            'zipcode.digits_between' => 'Le code postal doit contenir entre :min et :max chiffres.',

            'city.required' => 'La ville est obligatoire.',
            'city.string' => 'La ville doit être une chaîne de caractères.',
            'city.max' => 'La ville ne peut pas dépasser :max caractères.',

            'country.required' => 'Le code pays est obligatoire.',
            'country.size' => 'Le code pays doit contenir exactement 2 caractères.',

            'siret.required' => 'Le numéro SIRET est obligatoire.',
            'siret.regex' => 'Le numéro SIRET doit être au format : 123 456 789 01234.',
        ];
    }

}
