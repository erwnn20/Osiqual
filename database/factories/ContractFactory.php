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
        $startDate = fake()->dateTimeBetween('-2 years', '+2 years');

        return [
            'company_id' => $company->id,
            'start_date' => $startDate,
            'end_date' => $type->monthly ? fake()->dateTimeBetween($startDate, (clone $startDate)->modify('+6 month')) : null,
            'type_id' => $type->id,
        ];
    }
}
