<?php

namespace App\Modules\ArticleComments\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\ArticleComments\Models\ArticleComments;

class ArticleCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_article_comments(): void
    {
        $response = $this->getJson('/api/article_comments');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_ArticleComments(): void
    {
        $data = ['name' => 'Test ArticleComments'];

        $response = $this->postJson('/api/article_comments', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('article_comments', $data);
    }

    public function test_can_show_ArticleComments(): void
    {
        $ArticleComments = ArticleComments::factory()->create();

        $response = $this->getJson('/api/article_comments/' . $ArticleComments->id);
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

    public function test_can_update_ArticleComments(): void
    {
        $ArticleComments = ArticleComments::factory()->create();
        $data = ['name' => 'Updated ArticleComments'];

        $response = $this->putJson('/api/article_comments/' . $ArticleComments->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('article_comments', $data);
    }

    public function test_can_delete_ArticleComments(): void
    {
        $ArticleComments = ArticleComments::factory()->create();

        $response = $this->deleteJson('/api/article_comments/' . $ArticleComments->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('article_comments', ['id' => $ArticleComments->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/article_comments', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
