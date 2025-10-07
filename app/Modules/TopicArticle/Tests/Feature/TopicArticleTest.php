<?php

namespace App\Modules\TopicArticle\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TopicArticle\Models\TopicArticle;

class TopicArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_topic_articles(): void
    {
        $response = $this->getJson('/api/topic_articles');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TopicArticle(): void
    {
        $data = ['name' => 'Test TopicArticle'];

        $response = $this->postJson('/api/topic_articles', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('topic_articles', $data);
    }

    public function test_can_show_TopicArticle(): void
    {
        $TopicArticle = TopicArticle::factory()->create();

        $response = $this->getJson('/api/topic_articles/' . $TopicArticle->id);
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

    public function test_can_update_TopicArticle(): void
    {
        $TopicArticle = TopicArticle::factory()->create();
        $data = ['name' => 'Updated TopicArticle'];

        $response = $this->putJson('/api/topic_articles/' . $TopicArticle->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('topic_articles', $data);
    }

    public function test_can_delete_TopicArticle(): void
    {
        $TopicArticle = TopicArticle::factory()->create();

        $response = $this->deleteJson('/api/topic_articles/' . $TopicArticle->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('topic_articles', ['id' => $TopicArticle->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/topic_articles', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
