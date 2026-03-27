<?php

namespace App\Modules\TicketStatus\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TicketStatus\Models\TicketStatus;

class TicketStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_ticket_statuses(): void
    {
        $response = $this->getJson('/api/ticket_statuses');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TicketStatus(): void
    {
        $data = ['name' => 'Test TicketStatus'];

        $response = $this->postJson('/api/ticket_statuses', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_statuses', $data);
    }

    public function test_can_show_TicketStatus(): void
    {
        $TicketStatus = TicketStatus::factory()->create();

        $response = $this->getJson('/api/ticket_statuses/' . $TicketStatus->id);
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

    public function test_can_update_TicketStatus(): void
    {
        $TicketStatus = TicketStatus::factory()->create();
        $data = ['name' => 'Updated TicketStatus'];

        $response = $this->putJson('/api/ticket_statuses/' . $TicketStatus->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_statuses', $data);
    }

    public function test_can_delete_TicketStatus(): void
    {
        $TicketStatus = TicketStatus::factory()->create();

        $response = $this->deleteJson('/api/ticket_statuses/' . $TicketStatus->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('ticket_statuses', ['id' => $TicketStatus->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/ticket_statuses', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
