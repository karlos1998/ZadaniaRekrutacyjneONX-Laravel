<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Client;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                //return User::factory()->create()->id;
                return User::inRandomOrder()->first()->id;
            },
            'client_id' => function () {
                //return Client::factory()->create()->id;
                return Client::inRandomOrder()->first()->id;
            }
        ];
    }
}
