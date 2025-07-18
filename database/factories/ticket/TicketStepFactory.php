<?php

namespace Database\Factories\ticket;

use App\Models\Ticket;
use App\Models\Ticket\TicketStep;
use App\Models\User;
use App\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TicketStep>
 */
class TicketStepFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ticket = Ticket::inRandomOrder()->first() ?? Ticket::factory()->create();

        $technician = User::whereHas('role', fn($r) => $r->where('permission_technician', true))->inRandomOrder()->first() ??
            User::factory()->create([
                'role_id' => Role::where('permission_technician', true)->first()?->id ?? Role::factory()->create([
                        'name' => 'Technicien ' . Str::random(4),
                        'permission_technician' => true
                    ])->id
            ]);

        return [
            'ticket_id' => $ticket->id,
            'technician_id' => $technician->id,
            'description' => fake()->paragraph(),
            'date' => fake()->dateTimeBetween($ticket->creation_date, $ticket->end_date ?? 'now'),
        ];
    }
}
