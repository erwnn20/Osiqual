<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRoleRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($this->route('id'))],
            'admin' => ['nullable', 'boolean'],
            'tech' => ['nullable', 'boolean'],
            'client' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom du rôle est obligatoire.',
            'name.string' => 'Le nom du rôle doit être une chaîne de caractères.',
            'name.max' => 'Le nom du rôle ne peut pas dépasser 255 caractères.',
            'name.unique' => 'Ce nom de rôle est déjà utilisé.',

            'admin.boolean' => 'La valeur de "admin" doit être vraie ou fausse.',
            'tech.boolean' => 'La valeur de "tech" doit être vraie ou fausse.',
            'client.boolean' => 'La valeur de "client" doit être vraie ou fausse.',
        ];
    }
}
