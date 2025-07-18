<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class StatusTemplateRequest extends FormRequest
{
    protected static string $table;

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
            'name' => ['required', 'string', 'max:255', Rule::unique(self::$table, 'name')->ignore($this->route('id'))],
            'value' => ['required', 'integer', Rule::unique(self::$table, 'value')->ignore($this->route('id'))],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/', Rule::unique(self::$table, 'color')->ignore($this->route('id'))],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'name.unique' => 'Ce nom existe déjà.',

            'value.required' => 'La valeur est obligatoire.',
            'value.integer' => 'La valeur doit être un nombre entier.',
            'value.unique' => 'Cette valeur existe déjà.',

            'color.required' => 'La couleur est obligatoire.',
            'color.regex' => 'La couleur doit être un code hexadécimal valide, ex. : #FFFFFF.',
            'color.unique' => 'Cette couleur est déjà utilisée.',
        ];
    }

}
