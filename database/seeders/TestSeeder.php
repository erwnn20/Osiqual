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

        TicketCriticality::factory(4)->create();
        TicketPriority::factory(5)->create();
        TicketStatus::factory(6)->create();

        ContractStatus::factory(4)->create();
        ContractType::factory(5)->create();

        Company::factory(5)->create();

        User::factory()->create([
            'login' => 'admin',
            'role_id' => $admin->id
        ]); // admin
        User::factory()->create([
            'login' => 'tech',
            'role_id' => $tech->id
        ]); // tech
        User::factory()->create([
            'login' => 'client',
            'role_id' => $client->id
        ]); // client
        User::factory()->create([
            'login' => 'block',
            'role_id' => $client->id,
            'active' => 0
        ]); // block
        User::factory(6)->create();

        User::where('role_id', $client->id)->get()
            ->each(function ($user) {
                Contract::factory(3)->create([
                    'company_id' => $user->company->id,
                ]);
        });

        $ticketNumber = 25;
        Ticket::factory($ticketNumber)->create();
        TicketStep::factory($ticketNumber * 3)->create();

        dump('ok');
    }
}
