<?php

namespace App\Modules\TicketMaster\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TicketMaster\Models\TicketMaster;

class TicketMasterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_ticket_masters(): void
    {
        $response = $this->getJson('/api/ticket_masters');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TicketMaster(): void
    {
        $data = ['name' => 'Test TicketMaster'];

        $response = $this->postJson('/api/ticket_masters', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_masters', $data);
    }

    public function test_can_show_TicketMaster(): void
    {
        $TicketMaster = TicketMaster::factory()->create();

        $response = $this->getJson('/api/ticket_masters/' . $TicketMaster->id);
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

    public function test_can_update_TicketMaster(): void
    {
        $TicketMaster = TicketMaster::factory()->create();
        $data = ['name' => 'Updated TicketMaster'];

        $response = $this->putJson('/api/ticket_masters/' . $TicketMaster->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('ticket_masters', $data);
    }

    public function test_can_delete_TicketMaster(): void
    {
        $TicketMaster = TicketMaster::factory()->create();

        $response = $this->deleteJson('/api/ticket_masters/' . $TicketMaster->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('ticket_masters', ['id' => $TicketMaster->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/ticket_masters', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
