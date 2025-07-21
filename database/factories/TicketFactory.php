<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\Ticket\TicketCriticality;
use App\Models\Ticket\TicketPriority;
use App\Models\Ticket\TicketStatus;
use App\Models\User;
use App\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client = User::whereHas('role', fn($r) => $r->where('permission_client', true))->inRandomOrder()->first() ??
            User::factory()->create([
                'role_id' => Role::where('permission_client', true)->first()?->id ?? Role::factory()->create([
                        'name' => 'Client ' . Str::random(4),
                        'permission_client' => true
                    ])->id
            ]);

        $technician = User::whereHas('role', fn($r) => $r->where('permission_technician', true))->inRandomOrder()->first() ??
            User::factory()->create([
                'role_id' => Role::where('permission_technician', true)->first()?->id ?? Role::factory()->create([
                        'name' => 'Technicien ' . Str::random(4),
                        'permission_technician' => true
                    ])->id
            ]);

        $status = TicketStatus::inRandomOrder()->first() ?? TicketStatus::factory()->create();
        $priority = TicketPriority::inRandomOrder()->first() ?? TicketPriority::factory()->create();
        $criticality = TicketCriticality::inRandomOrder()->first() ?? TicketCriticality::factory()->create();

        do {
            $duration = fake()->numberBetween(0, 120);

            $createdAt = fake()->dateTimeBetween('-2 year', '+6 month')
                ->setTime(fake()->numberBetween(0, 23), fake()->numberBetween(0, 59));
            $endedAt = fake()->boolean(40)
                ? fake()->dateTimeBetween((clone $createdAt)->modify("+$duration minute"), (clone $createdAt)->modify('+5 days'))
                : null;
            $endedAt?->setTime($endedAt->format('H'), $endedAt->format('i'));

            $contract = $client->company->currentContract(Carbon::instance($createdAt));
        } while (is_null($contract) || $contract->type->duration - $contract->durationUsed() < $duration);

        return [
            'technician_id' => fake()->boolean(75) ? $technician?->id : null,
            'client_id' => $client->id,
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'duration' => $duration,
            'status_id' => $status->id,
            'priority_id' => $priority->id,
            'criticality_id' => $criticality->id,
            'creation_date' => $createdAt,
            'end_date' => $endedAt,
        ];
    }
}
