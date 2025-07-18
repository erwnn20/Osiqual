<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class TicketCriticalityRequest extends StatusTemplateRequest
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
        self::$table = 'ticket_criticalities';

        return parent::rules();
    }
}
