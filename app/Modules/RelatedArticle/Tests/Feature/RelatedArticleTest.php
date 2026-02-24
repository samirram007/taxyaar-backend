<?php

namespace App\Modules\RelatedArticle\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\RelatedArticle\Models\RelatedArticle;

class RelatedArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_related_articles(): void
    {
        $response = $this->getJson('/api/related_articles');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_RelatedArticle(): void
    {
        $data = ['name' => 'Test RelatedArticle'];

        $response = $this->postJson('/api/related_articles', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('related_articles', $data);
    }

    public function test_can_show_RelatedArticle(): void
    {
        $RelatedArticle = RelatedArticle::factory()->create();

        $response = $this->getJson('/api/related_articles/' . $RelatedArticle->id);
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

    public function test_can_update_RelatedArticle(): void
    {
        $RelatedArticle = RelatedArticle::factory()->create();
        $data = ['name' => 'Updated RelatedArticle'];

        $response = $this->putJson('/api/related_articles/' . $RelatedArticle->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('related_articles', $data);
    }

    public function test_can_delete_RelatedArticle(): void
    {
        $RelatedArticle = RelatedArticle::factory()->create();

        $response = $this->deleteJson('/api/related_articles/' . $RelatedArticle->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('related_articles', ['id' => $RelatedArticle->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/related_articles', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
