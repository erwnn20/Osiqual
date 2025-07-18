<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'firstname' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', Rule::unique('users', 'login')->ignore($this->route('id'))],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('id'))],
            'phone' => ['nullable', 'string', 'regex:/^\+?[0-9\s\-]{7,20}$/'],
            'company' => ['required', 'exists:companies,id'],
            'role' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required_with:password', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'lastname.required' => 'Le nom de famille est obligatoire.',
            'lastname.string' => 'Le nom de famille doit être une chaîne de caractères.',

            'login.required' => 'Le login est obligatoire.',
            'login.unique' => 'Ce login est déjà utilisé.',

            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',

            'phone.regex' => 'Le numéro de téléphone doit être valide.',

            'company.required' => 'La société est obligatoire.',
            'company.exists' => 'La société sélectionnée est invalide.',

            'role.required' => 'Le rôle est obligatoire.',
            'role.exists' => 'Le rôle sélectionné est invalide.',

            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',

            'password_confirmation.required_with' => 'La confirmation du mot de passe est obligatoire.',
            'password_confirmation.same' => 'La confirmation doit être identique au mot de passe.',
        ];
    }
}
