<?php

namespace Database\Factories;

use App\Models\UserPermission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPermission>
 */
class UserPermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->numberBetween(UserPermission::getPermissionTypeMin(), UserPermission::getPermissionTypeMax()),
        ];
    }
}
