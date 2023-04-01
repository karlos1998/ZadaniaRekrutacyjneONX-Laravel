<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Database\Seeders\CarSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
//use Database\Factories\CarFactory;
use App\Models\Car;


class CarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_get_all_cars(): void
    {
        $this->seed(CarSeeder::class);

        $response = $this->getJson('/api/cars');
        $response
        ->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('data', 'array')
            ->has('data.0', fn (AssertableJson $json) => 
                $json
                ->where('id', fn (int $id) => $id >= 1 )
                ->where('plate', fn (string $plate) => count(explode(' ', $plate)) == 2 )
                ->where('brand', fn (string $plate) => $plate != '' )
                ->etc()
            )
            ->missing('message')
        );
    }

    public function test_add_car(): void
    {
        $response = $this->postJson('/api/cars', [
            'plate' => 'WWY SUPRA',
            'brand' => 'Toyota',
        ]);
 
        $response
        ->assertStatus(201)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('data', 'array')
            ->has('data', fn (AssertableJson $json) => 
                $json
                ->where('id', fn (int $id) => $id >= 1 )
                ->where('plate', fn (string $plate) => count(explode(' ', $plate)) == 2 )
                ->where('brand', fn (string $plate) => $plate != '' )
                ->etc()
            )
            ->missing('message')
        );
    }

    public function test_add_car_valid_plate(): void
    {
        $response = $this->postJson('/api/cars', [
            'plate' => 'WWYSUPRA',
            'brand' => 'Toyota',
        ]);
 
        $response
        ->assertStatus(422)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('errors', 'array')
            ->whereType('errors.plate', 'array')
            ->has('message')
        );
    }

    public function test_update_plate_on_exist_car(): void
    {
        $car = Car::factory()->create();

        $response = $this->putJson("/api/cars/{$car->id}", [
            'plate' => 'WWY SUPRA',
        ]);
 
        $response
        ->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('data', 'array')
            ->has('data', fn (AssertableJson $json) => 
                $json
                ->where('id', $car->id )
                ->where('plate', 'WWY SUPRA')
                ->etc()
            )
            ->missing('message')
        );
    }

    public function test_delete_car(): void
    {
        $car = Car::factory()->create();

        $response = $this->deleteJson("/api/cars/{$car->id}");
 
        $response->assertStatus(204);
    }

}
