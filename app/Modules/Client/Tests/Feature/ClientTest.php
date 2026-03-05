<?php

namespace App\Modules\Client\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Client\Models\Client;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_clients(): void
    {
        $response = $this->getJson('/api/clients');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_Client(): void
    {
        $data = ['name' => 'Test Client'];

        $response = $this->postJson('/api/clients', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('clients', $data);
    }

    public function test_can_show_Client(): void
    {
        $Client = Client::factory()->create();

        $response = $this->getJson('/api/clients/' . $Client->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'name',
                         'created_at',
                         'updated_at'
                     ],
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_update_Client(): void
    {
        $Client = Client::factory()->create();
        $data = ['name' => 'Updated Client'];

        $response = $this->putJson('/api/clients/' . $Client->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('clients', $data);
    }

    public function test_can_delete_Client(): void
    {
        $Client = Client::factory()->create();

        $response = $this->deleteJson('/api/clients/' . $Client->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('clients', ['id' => $Client->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/clients', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
