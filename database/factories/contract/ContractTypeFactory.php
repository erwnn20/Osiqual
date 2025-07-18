<?php

namespace Database\Factories\contract;

use App\Models\Contract\ContractType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContractType>
 */
class ContractTypeFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $usedNames = [];
        static $possibleHours = [1, 2, 5, 10, 20, 50];

        $monthly = fake()->boolean();
        $hours = sizeof($usedNames) < sizeof($possibleHours) * 2 ? fake()->randomElement($possibleHours) : fake()->numberBetween(0, 100);
        $name = $monthly ? "Mensuel {$hours}h" : "Fixe {$hours}h";

        if (in_array($name, $usedNames)) return $this->definition();

        $usedNames[] = $name;
        return [
            'duration' => $hours * 60,
            'monthly' => $monthly,
        ];
    }
}
