<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolClassFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                '5А',
                '5Б',
                '6А',
                '6Б',
                '7А',
                '7Б',
                '8А',
                '8Б',
                '9А',
                '9Б',
                '10А',
                '10Б',
                '11А',
                '11Б',
            ]),

            'year' => fake()->numberBetween(2022, 2026),
        ];
    }
}