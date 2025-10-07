<?php

namespace App\Modules\HelpCenter\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\HelpCenter\Models\HelpCenter;

class HelpCenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_help_centers(): void
    {
        $response = $this->getJson('/api/help_centers');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_HelpCenter(): void
    {
        $data = ['name' => 'Test HelpCenter'];

        $response = $this->postJson('/api/help_centers', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('help_centers', $data);
    }

    public function test_can_show_HelpCenter(): void
    {
        $HelpCenter = HelpCenter::factory()->create();

        $response = $this->getJson('/api/help_centers/' . $HelpCenter->id);
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

    public function test_can_update_HelpCenter(): void
    {
        $HelpCenter = HelpCenter::factory()->create();
        $data = ['name' => 'Updated HelpCenter'];

        $response = $this->putJson('/api/help_centers/' . $HelpCenter->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('help_centers', $data);
    }

    public function test_can_delete_HelpCenter(): void
    {
        $HelpCenter = HelpCenter::factory()->create();

        $response = $this->deleteJson('/api/help_centers/' . $HelpCenter->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('help_centers', ['id' => $HelpCenter->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/help_centers', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
