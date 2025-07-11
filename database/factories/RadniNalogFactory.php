<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RadniNalog>
 */
class RadniNalogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kolicina_mleka' => fake()->randomNumber(2, true),
            'procenat_mm' => fake()->randomFloat(1, 1.8, 3.5),
            'primljeno' => fake()->boolean(),
            'komentar' => fake()->sentence(),
        ];
    }
}
