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
            'Défaut' => ['value' => 0, 'color' => '#3d3d3d', 'conditions' => []],
            'Ouvert' => ['value' => 1, 'color' => '#00B112',
                'conditions' => [
                    'start' => ['condition' => '>', 'logic' => '&&', 'column' => 'start_date', 'type' => 'date'],
                ]],
            'En cours' => ['value' => 2, 'color' => '#F07E26',
                'conditions' => [
                    'start' => ['condition' => '<=', 'logic' => '&&', 'column' => 'start_date', 'type' => 'date'],
                    'end' => ['condition' => '>=', 'logic' => '&&', 'column' => 'end_date', 'type' => 'date'],
                ]],
            'Terminé' => ['value' => 3, 'color' => '#DA3636',
                'conditions' => [
                    'end' => ['condition' => '<', 'logic' => '&&', 'column' => 'end_date', 'type' => 'date'],
                    'condition' => ['condition' => '>=', 'logic' => '||','value' => '100', 'column' => 'consumption', 'type' => 'percent'],
                ]],
        ];

        foreach ($possibleValues as $name => $data) {
            $value = is_array($data) ? $data['value'] : $data;
            $color = is_array($data) && isset($data['color']) ? $data['color'] : $defaultColor;
            $conditions = is_array($data) && isset($data['conditions']) ? $data['conditions'] : [];

            if (!in_array($value, $usedValues)) {
                $usedValues[] = $value;
                return [
                    'name' => $name,
                    'value' => $value,
                    'color' => $color,
                    'conditions' => $conditions,
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
