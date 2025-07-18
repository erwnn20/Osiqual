<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Ticket;
use App\Models\Ticket\TicketCriticality;
use App\Models\Ticket\TicketPriority;
use App\Models\Ticket\TicketStatus;
use App\Models\User;
use App\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
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

        $contract = $client->company->contracts()->inRandomOrder()->first() ??
            Contract::factory()->create(['company_id' => $client->company->id]);

        $status = TicketStatus::inRandomOrder()->first() ?? TicketStatus::factory()->create();
        $priority = TicketPriority::inRandomOrder()->first() ?? TicketPriority::factory()->create();
        $criticality = TicketCriticality::inRandomOrder()->first() ?? TicketCriticality::factory()->create();

        $createdAt = fake()->dateTimeBetween('-30 days')
            ->setTime(fake()->numberBetween(0, 23), fake()->numberBetween(0, 59));
        $endedAt = fake()->boolean(40)
            ? fake()->dateTimeBetween((clone $createdAt)->modify('+1 minute'), (clone $createdAt)->modify('+5 days'))
                ->setTime(fake()->numberBetween(0, 23), fake()->numberBetween(0, 59))
            : null;

        $duration = $endedAt ? fake()->numberBetween(5, 120) : 0;
        if ($contract->type->duration - $contract->durationUsed() < $duration)
            $contract = Contract::factory()->create(['company_id' => $client->company->id]);

        return [
            'technician_id' => fake()->boolean(75) ? $technician?->id : null,
            'client_id' => $client->id,
            'company_id' => $client->company->id,
            'contract_id' => $contract->id,
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
