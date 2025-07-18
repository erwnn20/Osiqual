<?php

namespace Database\Factories\user;

use App\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Role ' . Str::upper(Str::random(4)),
            'permission_admin' => false,
            'permission_technician' => false,
            'permission_client' => false,
        ];
    }
}
