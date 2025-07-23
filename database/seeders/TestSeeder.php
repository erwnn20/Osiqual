<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Contract\ContractStatus;
use App\Models\Contract\ContractType;
use App\Models\Ticket;
use App\Models\Ticket\TicketCriticality;
use App\Models\Ticket\TicketPriority;
use App\Models\Ticket\TicketStatus;
use App\Models\Ticket\TicketStep;
use App\Models\User;
use App\Models\User\Role;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = Role::factory()->create([
            'name' => 'Admin',
            'permission_admin' => true,
            'permission_technician' => true,
        ]);
        $tech = Role::factory()->create([
            'name' => 'Technicien',
            'permission_technician' => true,
        ]);
        $client = Role::factory()->create([
            'name' => 'Client',
            'permission_client' => true,
        ]);

        TicketCriticality::factory()->createMany([
            ['name' => 'Faible', 'value' => 1, 'color' => '#06B6D4'],
            ['name' => 'Moyenne', 'value' => 2, 'color' => '#00B112'],
            ['name' => 'Haute', 'value' => 3, 'color' => '#F07E26'],
            ['name' => 'Critique', 'value' => 4, 'color' => '#DA3636'],
        ]);
        TicketPriority::factory()->createMany([
            ['name' => 'Très basse', 'value' => 1, 'color' => '#0EA5E9'],
            ['name' => 'Basse', 'value' => 2, 'color' => '#06B6D4'],
            ['name' => 'Normale', 'value' => 3, 'color' => '#00B112'],
            ['name' => 'Haute', 'value' => 4, 'color' => '#F07E26'],
            ['name' => 'Urgente', 'value' => 5, 'color' => '#DA3636'],
        ]);
        TicketStatus::factory()->createMany([
            ['name' => 'Nouveau', 'value' => 1, 'color' => '#0EA5E9'],
            ['name' => 'Ouvert', 'value' => 2, 'color' => '#06B6D4'],
            ['name' => 'En cours', 'value' => 3, 'color' => '#00B112'],
            ['name' => 'En attente', 'value' => 4, 'color' => '#FFB733'],
            ['name' => 'Résolu', 'value' => 5, 'color' => '#F07E26'],
            ['name' => 'Fermé', 'value' => 6, 'color' => '#DA3636'],
        ]);

        ContractStatus::factory()->createMany([
            ['name' => 'Défaut', 'value' => 0, 'color' => '#3d3d3d', 'conditions' => []],
            ['name' => 'Ouvert', 'value' => 1, 'color' => '#00B112',
                'conditions' => [
                    'start' => ['condition' => '>', 'logic' => '&&', 'column' => 'start_date', 'type' => 'date'],
                ]
            ],
            ['name' => 'En cours', 'value' => 2, 'color' => '#F07E26',
                'conditions' => [
                    'start' => ['condition' => '<=', 'logic' => '&&', 'column' => 'start_date', 'type' => 'date'],
                    'end' => ['condition' => '>=', 'logic' => '&&', 'column' => 'end_date', 'type' => 'date'],
                ]
            ],
            ['name' => 'Terminé', 'value' => 3, 'color' => '#DA3636',
                'conditions' => [
                    'end' => ['condition' => '<', 'logic' => '&&', 'column' => 'end_date', 'type' => 'date'],
                    'consumption' => ['condition' => '>=', 'logic' => '||', 'value' => '100', 'column' => 'consumption', 'type' => 'percent'],
                ]
            ],
        ]);
        ContractType::factory(5)->create();

        Company::factory(5)->create();

        User::factory()->createMany([
            ['login' => 'admin', 'role_id' => $admin->id],
            ['login' => 'tech', 'role_id' => $tech->id],
            ['login' => 'client', 'role_id' => $client->id],
            ['login' => 'block', 'role_id' => $client->id, 'active' => 0]
        ]);
        User::factory(2)->create(['role_id' => $tech->id]);
        User::factory(3)->create(['role_id' => $client->id]);
        dump('users ok');

        User::where('role_id', $client->id)->get()
            ->each(fn($user) => Contract::factory(5)->create(['company_id' => $user->company->id,]));
        dump('contracts ok');

        $ticketNumber = 50;
        foreach (range(1, $ticketNumber) as $_) Ticket::factory()->create();
        dump('tickets ok');

        TicketStep::factory($ticketNumber * 3)->create();
        dump('steps ok');

        dump('ok');
    }
}
