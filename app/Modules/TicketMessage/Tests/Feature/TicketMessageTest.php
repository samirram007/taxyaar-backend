<?php

namespace App\Modules\TicketMessage\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TicketMessage\Models\TicketMessage;

class TicketMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_ticket_messages(): void
    {
        $response = $this->getJson('/api/ticket_messages');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TicketMessage(): void
    {
        $data = ['name' => 'Test TicketMessage'];

        $response = $this->postJson('/api/ticket_messages', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_messages', $data);
    }

    public function test_can_show_TicketMessage(): void
    {
        $TicketMessage = TicketMessage::factory()->create();

        $response = $this->getJson('/api/ticket_messages/' . $TicketMessage->id);
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

    public function test_can_update_TicketMessage(): void
    {
        $TicketMessage = TicketMessage::factory()->create();
        $data = ['name' => 'Updated TicketMessage'];

        $response = $this->putJson('/api/ticket_messages/' . $TicketMessage->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_messages', $data);
    }

    public function test_can_delete_TicketMessage(): void
    {
        $TicketMessage = TicketMessage::factory()->create();

        $response = $this->deleteJson('/api/ticket_messages/' . $TicketMessage->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('ticket_messages', ['id' => $TicketMessage->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/ticket_messages', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
