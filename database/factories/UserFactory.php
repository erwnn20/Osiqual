<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use App\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = 'password';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => $firstname = fake()->firstName(),
            'lastname' => $lastname = fake()->lastName(),
            'login' => strtolower(substr($firstname, 0, 1) . $lastname),
            'email' => strtolower($firstname . '.' . $lastname . '@example.com'),
            'phone' => fake()->phoneNumber(),
            'password' => Hash::make($this::$password),
            'role_id' => function () {
                return Role::inRandomOrder()->first()?->id
                    ?? Role::factory()->create()->id;
            },
            'company_id' => function () {
                return Company::inRandomOrder()->first()?->id
                    ?? Company::factory()->create()->id;
            },
        ];
    }
}
