<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Translation\PotentiallyTranslatedString;

class ColumnExists implements ValidationRule
{
    protected string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function passes($attribute, $value): bool
    {
        return Schema::hasColumn($this->table, $value);
    }

    public function message(): string
    {
        return 'La colonne sélectionnée ":input" n’existe pas dans la table "' . $this->table . '".';
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->passes($attribute, $value)) {
            $fail($this->message());
        }
    }
}
