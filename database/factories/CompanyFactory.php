<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->streetAddress(),
            'zipcode' => $this->faker->numberBetween(10000, 99999),
            'city' => $this->faker->city(),
            'country' => country(array_rand(countries()))->getIsoAlpha2(),
            'siret' => $this->faker->regexify('\d{3} \d{3} \d{3} \d{5}'),
        ];
    }
}
