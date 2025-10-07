<?php

namespace App\Modules\TopicSection\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TopicSection\Models\TopicSection;

class TopicSectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_topic_sections(): void
    {
        $response = $this->getJson('/api/topic_sections');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TopicSection(): void
    {
        $data = ['name' => 'Test TopicSection'];

        $response = $this->postJson('/api/topic_sections', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('topic_sections', $data);
    }

    public function test_can_show_TopicSection(): void
    {
        $TopicSection = TopicSection::factory()->create();

        $response = $this->getJson('/api/topic_sections/' . $TopicSection->id);
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

    public function test_can_update_TopicSection(): void
    {
        $TopicSection = TopicSection::factory()->create();
        $data = ['name' => 'Updated TopicSection'];

        $response = $this->putJson('/api/topic_sections/' . $TopicSection->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('topic_sections', $data);
    }

    public function test_can_delete_TopicSection(): void
    {
        $TopicSection = TopicSection::factory()->create();

        $response = $this->deleteJson('/api/topic_sections/' . $TopicSection->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('topic_sections', ['id' => $TopicSection->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/topic_sections', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
