<?php

namespace App\Modules\TicketEventType\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TicketEventType\Models\TicketEventType;

class TicketEventTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_ticket_event_types(): void
    {
        $response = $this->getJson('/api/ticket_event_types');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TicketEventType(): void
    {
        $data = ['name' => 'Test TicketEventType'];

        $response = $this->postJson('/api/ticket_event_types', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_event_types', $data);
    }

    public function test_can_show_TicketEventType(): void
    {
        $TicketEventType = TicketEventType::factory()->create();

        $response = $this->getJson('/api/ticket_event_types/' . $TicketEventType->id);
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

    public function test_can_update_TicketEventType(): void
    {
        $TicketEventType = TicketEventType::factory()->create();
        $data = ['name' => 'Updated TicketEventType'];

        $response = $this->putJson('/api/ticket_event_types/' . $TicketEventType->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_event_types', $data);
    }

    public function test_can_delete_TicketEventType(): void
    {
        $TicketEventType = TicketEventType::factory()->create();

        $response = $this->deleteJson('/api/ticket_event_types/' . $TicketEventType->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('ticket_event_types', ['id' => $TicketEventType->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/ticket_event_types', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
