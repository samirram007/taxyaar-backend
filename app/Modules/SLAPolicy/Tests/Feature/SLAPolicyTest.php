<?php

namespace App\Modules\SLAPolicy\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\SLAPolicy\Models\SLAPolicy;

class SLAPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_s_l_a_policies(): void
    {
        $response = $this->getJson('/api/s_l_a_policies');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_SLAPolicy(): void
    {
        $data = ['name' => 'Test SLAPolicy'];

        $response = $this->postJson('/api/s_l_a_policies', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('s_l_a_policies', $data);
    }

    public function test_can_show_SLAPolicy(): void
    {
        $SLAPolicy = SLAPolicy::factory()->create();

        $response = $this->getJson('/api/s_l_a_policies/' . $SLAPolicy->id);
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

    public function test_can_update_SLAPolicy(): void
    {
        $SLAPolicy = SLAPolicy::factory()->create();
        $data = ['name' => 'Updated SLAPolicy'];

        $response = $this->putJson('/api/s_l_a_policies/' . $SLAPolicy->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('s_l_a_policies', $data);
    }

    public function test_can_delete_SLAPolicy(): void
    {
        $SLAPolicy = SLAPolicy::factory()->create();

        $response = $this->deleteJson('/api/s_l_a_policies/' . $SLAPolicy->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('s_l_a_policies', ['id' => $SLAPolicy->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/s_l_a_policies', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
