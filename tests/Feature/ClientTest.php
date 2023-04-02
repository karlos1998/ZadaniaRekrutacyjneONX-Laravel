<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Database\Seeders\ClientSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Client;


class ClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_get_all_clients(): void
    {
        $this->seed(ClientSeeder::class);

        $response = $this->getJson('/api/clients');
        $response
        ->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('data', 'array')
            ->has('data.0', fn (AssertableJson $json) => 
                $json
                ->where('id', fn (int $id) => $id >= 1 )
                ->where('full_name', fn (string $full_name) => $full_name != '' )
                ->etc()
            )
            ->missing('message')
        );
    }

    public function test_add_client(): void
    {
        $response = $this->postJson('/api/clients', [
            'full_name' => 'Jan Kowalski',
        ]);
 
        $response
        ->assertStatus(201)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('data', 'array')
            ->has('data', fn (AssertableJson $json) => 
                $json
                ->where('id', fn (int $id) => $id >= 1 )
                ->where('full_name', 'Jan Kowalski')
                ->etc()
            )
            ->missing('message')
        );
    }

    public function test_update_name_on_exist_client(): void
    {
        $client = Client::factory()->create();

        $response = $this->putJson("/api/clients/{$client->id}", [
            'full_name' => 'Jan Kowalski',
        ]);
 
        $response
        ->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('data', 'array')
            ->has('data', fn (AssertableJson $json) => 
                $json
                ->where('id', $client->id )
                ->where('full_name', 'Jan Kowalski')
                ->etc()
            )
            ->missing('message')
        );
    }

    public function test_delete_client(): void
    {
        $client = Client::factory()->create();

        $response = $this->deleteJson("/api/clients/{$client->id}");
 
        $response->assertStatus(204);
    }


    public function test_get_client(): void
    {
        $client = Client::factory()->create();

        $response = $this->getJson("/api/clients/{$client->id}");
        $response
        ->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType('data', 'array')
            ->has('data', fn (AssertableJson $json) => 
                $json
                ->where('id', $client->id)
                ->where('full_name', fn (string $full_name) => $full_name != '' )
                ->etc()
            )
            ->missing('message')
        );
    }

}
