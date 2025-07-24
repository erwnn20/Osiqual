<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contract\ContractStatus;
use App\Models\Ticket\TicketCriticality;
use App\Models\Ticket\TicketPriority;
use App\Models\Ticket\TicketStatus;
use App\Models\User;
use App\Models\User\Role;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = Role::factory()->create([
            'name' => 'Administrateur',
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

        $company = Company::factory()->create([
            'name' => 'Osiqual',
//            'address' => '???',
            'zipcode' => 31000,
            'city' => 'Toulouse',
            'country' => 'FR',
//            'siret' => '???',
            ]);

        User::factory()->create([
            'firstname' => null,
            'lastname' => 'Administrateur',
            'login' => 'admin',
            'email' => 'administrateur@osiqual.fr',
            'phone' => null,
            'role_id' => $admin->id,
            'company_id' => $company->id,
        ]); // default user

        dump('ok');
    }
}
