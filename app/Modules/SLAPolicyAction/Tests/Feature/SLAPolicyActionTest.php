<?php

namespace App\Modules\SLAPolicyAction\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\SLAPolicyAction\Models\SLAPolicyAction;

class SLAPolicyActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_s_l_a_policy_actions(): void
    {
        $response = $this->getJson('/api/s_l_a_policy_actions');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_SLAPolicyAction(): void
    {
        $data = ['name' => 'Test SLAPolicyAction'];

        $response = $this->postJson('/api/s_l_a_policy_actions', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('s_l_a_policy_actions', $data);
    }

    public function test_can_show_SLAPolicyAction(): void
    {
        $SLAPolicyAction = SLAPolicyAction::factory()->create();

        $response = $this->getJson('/api/s_l_a_policy_actions/' . $SLAPolicyAction->id);
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

    public function test_can_update_SLAPolicyAction(): void
    {
        $SLAPolicyAction = SLAPolicyAction::factory()->create();
        $data = ['name' => 'Updated SLAPolicyAction'];

        $response = $this->putJson('/api/s_l_a_policy_actions/' . $SLAPolicyAction->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('s_l_a_policy_actions', $data);
    }

    public function test_can_delete_SLAPolicyAction(): void
    {
        $SLAPolicyAction = SLAPolicyAction::factory()->create();

        $response = $this->deleteJson('/api/s_l_a_policy_actions/' . $SLAPolicyAction->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('s_l_a_policy_actions', ['id' => $SLAPolicyAction->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/s_l_a_policy_actions', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
