<?php

namespace App\Modules\TopicCategory\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TopicCategory\Models\TopicCategory;

class TopicCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_topic_categories(): void
    {
        $response = $this->getJson('/api/topic_categories');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TopicCategory(): void
    {
        $data = ['name' => 'Test TopicCategory'];

        $response = $this->postJson('/api/topic_categories', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('topic_categories', $data);
    }

    public function test_can_show_TopicCategory(): void
    {
        $TopicCategory = TopicCategory::factory()->create();

        $response = $this->getJson('/api/topic_categories/' . $TopicCategory->id);
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

    public function test_can_update_TopicCategory(): void
    {
        $TopicCategory = TopicCategory::factory()->create();
        $data = ['name' => 'Updated TopicCategory'];

        $response = $this->putJson('/api/topic_categories/' . $TopicCategory->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('topic_categories', $data);
    }

    public function test_can_delete_TopicCategory(): void
    {
        $TopicCategory = TopicCategory::factory()->create();

        $response = $this->deleteJson('/api/topic_categories/' . $TopicCategory->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('topic_categories', ['id' => $TopicCategory->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/topic_categories', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
