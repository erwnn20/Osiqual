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
        static $defaultColor = '#1E1E1E';
        static $usedValues = [];
        static $possibleValues = [
            'Ouvert' => ['value' => 1, 'color' => '#00B112'],
            'En cours' => ['value' => 2, 'color' => '#F07E26'],
            'Terminé' => ['value' => 3, 'color' => '#DA3636'],
        ];

        foreach ($possibleValues as $name => $data) {
            $value = is_array($data) ? $data['value'] : $data;
            $color = is_array($data) && isset($data['color']) ? $data['color'] : $defaultColor;

            if (!in_array($value, $usedValues)) {
                $usedValues[] = $value;
                return [
                    'name' => $name,
                    'value' => $value,
                    'color' => $color,
                    'conditions' => [],
                ];
            }
        }

        do {
            $value = fake()->unique()->numberBetween(5, 99);
        } while (in_array($value, $usedValues));
        $usedValues[] = $value;

        return [
            'name' => 'Status ' . $value,
            'value' => $value,
            'color' => $defaultColor,
            'conditions' => [],
        ];
    }
}
