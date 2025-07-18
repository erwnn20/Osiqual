<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContractUpdateRequest extends ContractCreateRequest
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
            'status' => ['required', 'exists:contract_statuses,id'],
            'start' => ['required', 'date', 'regex:/^\d{4}-\d{2}(-\d{2})?$/'],
            'end' => ['nullable', 'date', 'regex:/^\d{4}-\d{2}(-\d{2})?$/', 'after:start'],
        ];
    }
}
