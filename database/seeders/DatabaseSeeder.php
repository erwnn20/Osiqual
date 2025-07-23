<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contract\ContractStatus;
use App\Models\Contract\ContractType;
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

        TicketCriticality::factory(4)->create();
        TicketPriority::factory(5)->create();
        TicketStatus::factory(6)->create();

        ContractStatus::factory(4)->create();
        ContractType::factory(5)->create();

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
