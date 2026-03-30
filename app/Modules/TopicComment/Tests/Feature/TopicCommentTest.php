<?php

namespace App\Modules\TopicComment\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TopicComment\Models\TopicComment;

class TopicCommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_topic_comments(): void
    {
        $response = $this->getJson('/api/topic_comments');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TopicComment(): void
    {
        $data = ['name' => 'Test TopicComment'];

        $response = $this->postJson('/api/topic_comments', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('topic_comments', $data);
    }

    public function test_can_show_TopicComment(): void
    {
        $TopicComment = TopicComment::factory()->create();

        $response = $this->getJson('/api/topic_comments/' . $TopicComment->id);
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

    public function test_can_update_TopicComment(): void
    {
        $TopicComment = TopicComment::factory()->create();
        $data = ['name' => 'Updated TopicComment'];

        $response = $this->putJson('/api/topic_comments/' . $TopicComment->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('topic_comments', $data);
    }

    public function test_can_delete_TopicComment(): void
    {
        $TopicComment = TopicComment::factory()->create();

        $response = $this->deleteJson('/api/topic_comments/' . $TopicComment->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('topic_comments', ['id' => $TopicComment->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/topic_comments', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
