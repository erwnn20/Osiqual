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
        static $usedValues = [];

        $minValue = TicketPriority::min('value');
        $usedValues[] = (empty($usedValues) ? $minValue : min($minValue, min($usedValues))) - 1;
        $value = min($usedValues);

        return [
            'name' => 'Priorité ' . $value,
            'value' => $value,
            'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
        ];
    }
}
