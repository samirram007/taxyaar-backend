<?php

namespace App\Modules\SLAPolicyRule\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\SLAPolicyRule\Models\SLAPolicyRule;

class SLAPolicyRuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_s_l_a_policy_rules(): void
    {
        $response = $this->getJson('/api/s_l_a_policy_rules');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_SLAPolicyRule(): void
    {
        $data = ['name' => 'Test SLAPolicyRule'];

        $response = $this->postJson('/api/s_l_a_policy_rules', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('s_l_a_policy_rules', $data);
    }

    public function test_can_show_SLAPolicyRule(): void
    {
        $SLAPolicyRule = SLAPolicyRule::factory()->create();

        $response = $this->getJson('/api/s_l_a_policy_rules/' . $SLAPolicyRule->id);
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

    public function test_can_update_SLAPolicyRule(): void
    {
        $SLAPolicyRule = SLAPolicyRule::factory()->create();
        $data = ['name' => 'Updated SLAPolicyRule'];

        $response = $this->putJson('/api/s_l_a_policy_rules/' . $SLAPolicyRule->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('s_l_a_policy_rules', $data);
    }

    public function test_can_delete_SLAPolicyRule(): void
    {
        $SLAPolicyRule = SLAPolicyRule::factory()->create();

        $response = $this->deleteJson('/api/s_l_a_policy_rules/' . $SLAPolicyRule->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('s_l_a_policy_rules', ['id' => $SLAPolicyRule->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/s_l_a_policy_rules', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
