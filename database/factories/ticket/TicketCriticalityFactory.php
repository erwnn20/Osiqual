<?php

namespace Database\Factories\ticket;

use App\Models\Ticket\TicketCriticality;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketCriticality>
 */
class TicketCriticalityFactory extends Factory
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
            'Faible' => ['value' => 1, 'color' => '#06B6D4'],
            'Moyenne' => ['value' => 2, 'color' => '#00B112'],
            'Haute' => ['value' => 3, 'color' => '#F07E26'],
            'Critique' => ['value' => 4, 'color' => '#DA3636'],
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
                ];
            }
        }

        do {
            $value = fake()->unique()->numberBetween(5, 99);
        } while (in_array($value, $usedValues));
        $usedValues[] = $value;

        return [
            'name' => 'Criticité ' . $value,
            'value' => $value,
            'color' => $defaultColor,
        ];
    }
}
