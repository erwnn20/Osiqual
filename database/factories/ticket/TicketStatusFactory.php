<?php

namespace Database\Factories\ticket;

use App\Models\Ticket\TicketStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketStatus>
 */
class TicketStatusFactory extends Factory
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
            'Nouveau' => ['value' => 1, 'color' => '#0EA5E9'],
            'Ouvert' => ['value' => 2, 'color' => '#06B6D4'],
            'En cours' => ['value' => 3, 'color' => '#00B112'],
            'En attente' => ['value' => 4, 'color' => '#FFB733'],
            'Résolu' => ['value' => 5, 'color' => '#F07E26'],
            'Fermé' => ['value' => 6, 'color' => '#DA3636'],
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
            'name' => 'Status ' . $value,
            'value' => $value,
            'color' => $defaultColor,
        ];
    }
}
