<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    public function definition(): array
    {
        return  [
            'name' => fake()->company(),
            'identifier' => fake()->unique()->word(),
            'parent_id' => null
        ];
    }
}
