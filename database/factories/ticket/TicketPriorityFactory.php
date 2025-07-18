<?php

namespace Database\Factories\ticket;

use App\Models\Ticket\TicketPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketPriority>
 */
class TicketPriorityFactory extends Factory
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
            'Très basse' => ['value' => 1, 'color' => '#0EA5E9'],
            'Basse' => ['value' => 2, 'color' => '#06B6D4'],
            'Normale' => ['value' => 3, 'color' => '#00B112'],
            'Haute' => ['value' => 4, 'color' => '#F07E26'],
            'Urgente' => ['value' => 5, 'color' => '#DA3636'],
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
            'name' => 'Priorité ' . $value,
            'value' => $value,
            'color' => $defaultColor,
        ];
    }
}
