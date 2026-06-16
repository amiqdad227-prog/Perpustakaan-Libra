<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Teknologi', 'Novel', 'Sains', 'Sejarah', 'Bisnis']),
            'description' => fake()->sentence(),
        ];
    }
}
