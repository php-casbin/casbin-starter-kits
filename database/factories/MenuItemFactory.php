<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{

    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'identifier' => fake()->unique()->word()
        ];
    }
}
