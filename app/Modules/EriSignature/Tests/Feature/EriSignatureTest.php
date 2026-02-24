<?php

namespace App\Modules\EriSignature\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\EriSignature\Models\EriSignature;

class EriSignatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_eri_signatures(): void
    {
        $response = $this->getJson('/api/eri_signatures');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_EriSignature(): void
    {
        $data = ['name' => 'Test EriSignature'];

        $response = $this->postJson('/api/eri_signatures', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('eri_signatures', $data);
    }

    public function test_can_show_EriSignature(): void
    {
        $EriSignature = EriSignature::factory()->create();

        $response = $this->getJson('/api/eri_signatures/' . $EriSignature->id);
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

    public function test_can_update_EriSignature(): void
    {
        $EriSignature = EriSignature::factory()->create();
        $data = ['name' => 'Updated EriSignature'];

        $response = $this->putJson('/api/eri_signatures/' . $EriSignature->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('eri_signatures', $data);
    }

    public function test_can_delete_EriSignature(): void
    {
        $EriSignature = EriSignature::factory()->create();

        $response = $this->deleteJson('/api/eri_signatures/' . $EriSignature->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('eri_signatures', ['id' => $EriSignature->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/eri_signatures', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
