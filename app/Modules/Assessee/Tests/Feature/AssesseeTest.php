<?php

namespace App\Modules\Assessee\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Assessee\Models\Assessee;

class AssesseeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_assessees(): void
    {
        $response = $this->getJson('/api/assessees');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_Assessee(): void
    {
        $data = ['name' => 'Test Assessee'];

        $response = $this->postJson('/api/assessees', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('assessees', $data);
    }

    public function test_can_show_Assessee(): void
    {
        $Assessee = Assessee::factory()->create();

        $response = $this->getJson('/api/assessees/' . $Assessee->id);
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

    public function test_can_update_Assessee(): void
    {
        $Assessee = Assessee::factory()->create();
        $data = ['name' => 'Updated Assessee'];

        $response = $this->putJson('/api/assessees/' . $Assessee->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('assessees', $data);
    }

    public function test_can_delete_Assessee(): void
    {
        $Assessee = Assessee::factory()->create();

        $response = $this->deleteJson('/api/assessees/' . $Assessee->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('assessees', ['id' => $Assessee->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/assessees', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
