<?php

namespace App\Modules\TicketType\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TicketType\Models\TicketType;

class TicketTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_ticket_types(): void
    {
        $response = $this->getJson('/api/ticket_types');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TicketType(): void
    {
        $data = ['name' => 'Test TicketType'];

        $response = $this->postJson('/api/ticket_types', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_types', $data);
    }

    public function test_can_show_TicketType(): void
    {
        $TicketType = TicketType::factory()->create();

        $response = $this->getJson('/api/ticket_types/' . $TicketType->id);
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

    public function test_can_update_TicketType(): void
    {
        $TicketType = TicketType::factory()->create();
        $data = ['name' => 'Updated TicketType'];

        $response = $this->putJson('/api/ticket_types/' . $TicketType->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_types', $data);
    }

    public function test_can_delete_TicketType(): void
    {
        $TicketType = TicketType::factory()->create();

        $response = $this->deleteJson('/api/ticket_types/' . $TicketType->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('ticket_types', ['id' => $TicketType->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/ticket_types', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
