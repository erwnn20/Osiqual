<?php

namespace App\Http\Requests;

use App\Models\Contract\ContractStatus;
use App\Rules\ColumnExists;
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
     * Condition structure :
     *  - $prefix . '-condition' => ['nullable', 'in:<,>', ...], // superior or inferior condition
     *  - $prefix . '-condition-equal' => ['nullable', ...], // equality condition
     *
     *  - $prefix . '-value' => ['nullable', ..., // to be specified according to the type of value you want
     *                        'required_with:$prefix . '-condition,$prefix . '-condition-equal'], // required if a condition is entered
     *
     *   - $prefix . '-logic' => ['nullable', 'in:&&,||', ..., // input not required, if absent, condition compared with “&&”
     *                          'required_with:$prefix . '-condition,$prefix . '-condition-equal'], // if input present, required if a condition is entered
     *
     *  - $prefix . '-column' => ['nullable', new ColumnExists('your-table'), ...], // corresponds to the table column to which the value will be compared, if not specified, the column will be the prefix
     *
     *  - $prefix . '-type' => ['nullable', ...], // corresponds to the type of value ‘-value’ will take during comparison (see ContractStatus::createConditions)
     *
     * @return array<string, ValidationRule|array|string>
     *
     * @see ContractStatus::createConditions()
     *
     */
    public function rules(): array
    {
        self::$table = 'contract_statuses';

        return parent::rules() +
            [
                'start-condition' => ['nullable', 'in:<,>'],
                'start-condition-equal' => ['nullable'],
                'start-value' => ['nullable', 'date', 'date_format:Y-m-d\TH:i'],
                'start-column' => ['nullable', 'string', new ColumnExists('contracts')],
                'start-type' => ['nullable'],
            ] +
            [
                'end-condition' => ['nullable', 'in:<,>'],
                'end-condition-equal' => ['nullable'],
                'end-value' => ['nullable', 'date', 'date_format:Y-m-d\TH:i'],
                'end-column' => ['nullable', 'string', new ColumnExists('contracts')],
                'end-type' => ['nullable'],
            ] +
            [
                'consumption-condition' => ['nullable', 'in:<,>'],
                'consumption-condition-equal' => ['nullable'],
                'consumption-value' => ['nullable', 'integer', 'between:0,100',
                    'required_with:consumption-condition,consumption-condition-equal'],
                'consumption-logic' => ['nullable', 'in:&&,||',
                    'required_with:consumption-condition,consumption-condition-equal'],
                'consumption-type' => ['nullable'],
            ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $prefixes = ['consumption', 'start', 'end'];

            foreach ($prefixes as $prefix) {
                $value = $this->input($prefix . '-value');
                $condition = $this->input($prefix . '-condition');
                $equal = $this->input($prefix . '-condition-equal');

                $hasCondition = $condition || $equal;

                if ($value && !$hasCondition) {
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

                // CONSUMPTION
                'consumption-condition.in' => 'L’opérateur de durée doit être "<" ou ">".',
                'consumption-condition-equal.required_with' => 'Veuillez préciser une égalité si une condition est renseignée.',
                'consumption-logic.required_with' => 'L’opérateur logique de durée est requis si une condition est sélectionnée.',
                'consumption-logic.in' => 'L’opérateur logique de durée doit être "&&" (ET) ou "||" (OU).',
                'consumption-value.required_with' => 'Veuillez entrer une valeur si une condition de durée est sélectionnée.',
                'consumption-value.integer' => 'La durée doit être un entier.',
                'consumption-value.between' => 'La durée doit être comprise entre 0 et 100.',

                // START
                'start-condition.in' => 'L’opérateur de date de début doit être "<" ou ">".',
                'start-value.date' => 'La date de début doit être une date valide.',
                'start-value.date_format' => 'La date de début doit être au format YYYY-MM-DDTHH:MM.',
                'start-column.string' => 'Le nom de la colonne de date de début doit être une chaîne de caractères.',

                // END
                'end-condition.in' => 'L’opérateur de date de fin doit être "<" ou ">".',
                'end-value.date' => 'La date de fin doit être une date valide.',
                'end-value.date_format' => 'La date de fin doit être au format YYYY-MM-DDTHH:MM.',
                'end-column.string' => 'Le nom de la colonne de date de fin doit être une chaîne de caractères.',
            ];
    }

}
