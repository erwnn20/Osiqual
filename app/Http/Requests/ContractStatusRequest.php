<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class ContractStatusRequest extends StatusTemplateRequest
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
        self::$table = 'contract_statuses';

        return parent::rules() + [
                'duration-condition' => ['nullable', 'in:<,>'],
                'duration-condition-equal' => ['nullable'],
                'duration-logic' => ['nullable', 'in:&&,||',
                    'required_with:duration-condition,duration-condition-equal'],
                'duration-value' => ['nullable', 'integer', 'between:0,100',
                    'required_with:duration-condition,duration-condition-equal'],

                'start-condition' => ['nullable', 'in:<,>'],
                'start-condition-equal' => ['nullable'],
                'start-value' => ['nullable', 'date', 'date_format:Y-m-d\TH:i'],

                'end-condition' => ['nullable', 'in:<,>'],
                'end-condition-equal' => ['nullable'],
                'end-value' => ['nullable', 'date', 'date_format:Y-m-d\TH:i'],
            ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $prefixes = ['duration', 'start', 'end'];

            foreach ($prefixes as $prefix) {
                $value = $this->input($prefix . '-value');
                $condition = $this->input($prefix . '-condition');
                $equal = $this->input($prefix . '-condition-equal');

                if ($value && !$condition && !$equal) {
                    $validator->errors()->add(
                        $prefix . '-condition',
                        'Une condition est requise si une valeur est renseignée.'
                    );
                    $validator->errors()->add(
                        $prefix . '-condition-equal',
                        'Une condition est requise si une valeur est renseignée.'
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return parent::messages() + [
                'duration-condition.in' => 'L’opérateur de durée doit être "<", "=" ou ">".',
                'duration-logic.required_with' => 'L’opérateur logique de durée est requis si une condition est sélectionnée.',
                'duration-logic.in' => 'L’opérateur logique de durée doit être soit "&&" (ET) soit "||" (OU).',
                'duration-value.required_with' => 'Veuillez entrer une valeur si une condition de durée est sélectionnée.',
                'duration-value.integer' => 'La durée doit être un entier.',
                'duration-value.between' => 'La durée doit être comprise entre 0 et 100.',

//                'start-condition.required_with' => 'La condition de début est requise lorsque la valeur de début est renseignée.',
                'start-condition.in' => 'L’opérateur de date de début doit être "<", "=" ou ">".',
                'start-value.date' => 'La date de début doit être une date valide.',
                'start-value.date_format' => 'La date de début doit être au format YYYY-MM-DD HH:MM.',

//                'end-condition.required_with' => 'La condition de fin est requise lorsque la valeur de fin est renseignée.',
                'end-condition.in' => 'L’opérateur de date de fin doit être "<", "=" ou ">".',
                'end-value.date' => 'La date de fin doit être une date valide.',
                'end-value.date_format' => 'La date de fin doit être au format YYYY-MM-DD HH:MM.',
            ];
    }

}
