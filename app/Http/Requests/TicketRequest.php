<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
//        $this->dd();
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'client' => ['required', 'exists:users,id'],
            'technician' => ['nullable', 'exists:users,id'],
            'duration' => ['nullable', 'integer', 'min:0'],
            'creation' => ['nullable', 'required_with:end', 'date', 'date_format:Y-m-d\TH:i',],
            'end' => ['nullable', 'date', 'date_format:Y-m-d\TH:i', 'after_or_equal:creation'],
            'status' => ['required', 'exists:ticket_statuses,id'],
            'priority' => ['required', 'exists:ticket_priorities,id'],
            'criticality' => ['required', 'exists:ticket_criticalities,id'],
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
            'title.required' => 'Le titre est obligatoire.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',

            'description.string' => 'La description doit être une chaîne de caractères.',

            'client.required' => 'Le client est obligatoire.',
            'client.exists' => 'Le client sélectionné est invalide.',

            'technician.exists' => 'Le technicien sélectionné est invalide.',

            'duration.integer' => 'La durée doit être un nombre entier.',
            'duration.min' => 'La durée doit être au minimum de 0.',

            'creation.required_with' => 'La date de création est obligatoire si une date de fin est entrée.',
            'creation.date' => 'La date de création doit être une date valide.',
            'creation.date_format' => 'La date de création doit être au format YYYY-MM-DD HH:MM.',

            'end.date' => 'La date de fin doit être une date valide.',
            'end.date_format' => 'La date de fin doit être au format YYYY-MM-DD HH:MM.',
            'end.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de création.',

            'status.required' => 'Le statut est obligatoire.',
            'status.exists' => 'Le statut sélectionné est invalide.',

            'priority.required' => 'La priorité est obligatoire.',
            'priority.exists' => 'La priorité sélectionnée est invalide.',

            'criticality.required' => 'La criticité est obligatoire.',
            'criticality.exists' => 'La criticité sélectionnée est invalide.',
        ];
    }
}
