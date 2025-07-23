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
        return [
            'company_id' => Company::inRandomOrder()->first() ?? Company::factory()->create()->id,
            'type_id' => ($type = ContractType::inRandomOrder()->first() ?? ContractType::factory()->create())->id,
            'start_date' => $startDate = fake()->dateTimeBetween('-2 years', '+2 years'),
            'end_date' => $type->monthly ? fake()->dateTimeBetween($startDate, (clone $startDate)->modify('+6 month')) : null,
        ];
    }
}
