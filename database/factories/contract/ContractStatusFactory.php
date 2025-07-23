<?php

namespace Database\Factories\contract;

use App\Models\Contract\ContractStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContractStatus>
 */
class ContractStatusFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $usedValues = [];

        $minValue = ContractStatus::min('value');
        $usedValues[] = (empty($usedValues) ? $minValue : min($minValue, min($usedValues))) - 1;
        $value = min($usedValues);

        return [
            'name' => 'Status ' . $value,
            'value' => $value,
            'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            'conditions' => [],
        ];
    }
}
