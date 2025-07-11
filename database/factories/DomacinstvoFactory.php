<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domacinstvo>
 */
class DomacinstvoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'naziv' => fake()->company(),
            'adresa' => fake()->address(),
            'koordinate' => fake()->latitude(44.7, 44.9) . ',' . fake()->longitude(20.2, 20.6),
            'tipovi_mleka' => collect(['kravlje', 'kozije', 'ovcije'])->random(2)->implode(',')
        ];
    }
}
