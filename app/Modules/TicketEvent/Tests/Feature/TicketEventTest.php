<?php

namespace App\Modules\TicketEvent\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TicketEvent\Models\TicketEvent;

class TicketEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_ticket_events(): void
    {
        $response = $this->getJson('/api/ticket_events');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TicketEvent(): void
    {
        $data = ['name' => 'Test TicketEvent'];

        $response = $this->postJson('/api/ticket_events', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_events', $data);
    }

    public function test_can_show_TicketEvent(): void
    {
        $TicketEvent = TicketEvent::factory()->create();

        $response = $this->getJson('/api/ticket_events/' . $TicketEvent->id);
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

    public function test_can_update_TicketEvent(): void
    {
        $TicketEvent = TicketEvent::factory()->create();
        $data = ['name' => 'Updated TicketEvent'];

        $response = $this->putJson('/api/ticket_events/' . $TicketEvent->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_events', $data);
    }

    public function test_can_delete_TicketEvent(): void
    {
        $TicketEvent = TicketEvent::factory()->create();

        $response = $this->deleteJson('/api/ticket_events/' . $TicketEvent->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('ticket_events', ['id' => $TicketEvent->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/ticket_events', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
