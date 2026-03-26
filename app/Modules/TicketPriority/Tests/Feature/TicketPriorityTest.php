<?php

namespace App\Modules\TicketPriority\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TicketPriority\Models\TicketPriority;

class TicketPriorityTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_ticket_priorities(): void
    {
        $response = $this->getJson('/api/ticket_priorities');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TicketPriority(): void
    {
        $data = ['name' => 'Test TicketPriority'];

        $response = $this->postJson('/api/ticket_priorities', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_priorities', $data);
    }

    public function test_can_show_TicketPriority(): void
    {
        $TicketPriority = TicketPriority::factory()->create();

        $response = $this->getJson('/api/ticket_priorities/' . $TicketPriority->id);
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

    public function test_can_update_TicketPriority(): void
    {
        $TicketPriority = TicketPriority::factory()->create();
        $data = ['name' => 'Updated TicketPriority'];

        $response = $this->putJson('/api/ticket_priorities/' . $TicketPriority->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_priorities', $data);
    }

    public function test_can_delete_TicketPriority(): void
    {
        $TicketPriority = TicketPriority::factory()->create();

        $response = $this->deleteJson('/api/ticket_priorities/' . $TicketPriority->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('ticket_priorities', ['id' => $TicketPriority->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/ticket_priorities', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
