<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Database\Seeders\UserSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\User;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_get_all_users(): void
    {
        $this->seed(UserSeeder::class);

        $response = $this->getJson('/api/users');
        $response
        ->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('data', 'array')
            ->has('data.0', fn (AssertableJson $json) => 
                $json
                ->where('id', fn (int $id) => $id >= 1 )
                ->where('name', fn (string $name) => $name != '' )
                ->where('email', fn (string $email) => $email != '' )
                ->etc()
            )
            ->missing('message')
        );
    }

    public function test_add_user(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Str::random(8)
        ]);
 
        $response
        ->assertStatus(201)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('data', 'array')
            ->has('data', fn (AssertableJson $json) => 
                $json
                ->where('id', fn (int $id) => $id >= 1 )
                ->where('name', fn (string $name) => $name != '' )
                ->where('email', fn (string $email) => $email != '' )
                ->etc()
            )
            ->missing('message')
        );
    }

    public function test_update_password_on_exist_user(): void
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'password' => Str::random(8)
        ]);
 
        $response
        ->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('data', 'array')
            ->has('data', fn (AssertableJson $json) => 
                $json
                ->where('id', $user->id )
                ->etc()
            )
            ->missing('message')
        );
    }

    public function test_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");
 
        $response->assertStatus(204);
    }


    public function test_get_user(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");
        $response
        ->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('data', 'array')
            ->has('data', fn (AssertableJson $json) => 
                $json
                ->where('id', $user->id)
                ->where('name', fn (string $name) => $name != '' )
                ->where('email', fn (string $email) => $email != '' )
                ->etc()
            )
            ->missing('message')
        );
    }

}
