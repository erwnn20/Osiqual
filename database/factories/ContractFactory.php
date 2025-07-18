<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Contract\ContractStatus;
use App\Models\Contract\ContractType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = Company::inRandomOrder()->first() ?? Company::factory()->create();
        $type = ContractType::inRandomOrder()->first() ?? ContractType::factory()->create();
        $status = ContractStatus::inRandomOrder()->first() ?? ContractStatus::factory()->create();
        $startDate = fake()->dateTimeBetween('-2 year');

        return [
            'company_id' => $company->id,
            'start_date' => $startDate,
            'end_date' => $type->monthly ? fake()->dateTimeBetween($startDate, '+6 month') : null,
            'status_id' => $status->id,
            'type_id' => $type->id,
        ];
    }
}
