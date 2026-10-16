<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class PupilFactory extends Factory
{
    public function definition(): array
    {
        return [
            'school_class_id' => SchoolClass::factory(),

            'full_name' => fake()->name(),

            'birth_date' => fake()
                ->dateTimeBetween('-18 years', '-7 years')
                ->format('Y-m-d'),

            'email' => fake()
                ->unique()
                ->safeEmail(),

            'average_score' => fake()
                ->randomFloat(2, 2, 5),

            'has_benefit' => fake()->boolean(20),
        ];
    }
}