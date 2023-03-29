<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = ['Toyota', 'Nissan', 'Lexus', 'Subaru', 'Mitsubishi', 'Acura'];
        return [
            'brand' => $brands[array_rand($brands)],
            'plate' => 'WWY ' . rand(1000, 10000)
        ];
    }
}
