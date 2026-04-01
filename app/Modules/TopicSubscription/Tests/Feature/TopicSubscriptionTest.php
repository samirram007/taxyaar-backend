<?php

namespace App\Modules\TopicSubscription\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\TopicSubscription\Models\TopicSubscription;

class TopicSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_topic_subscriptions(): void
    {
        $response = $this->getJson('/api/topic_subscriptions');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_TopicSubscription(): void
    {
        $data = ['name' => 'Test TopicSubscription'];

        $response = $this->postJson('/api/topic_subscriptions', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('topic_subscriptions', $data);
    }

    public function test_can_show_TopicSubscription(): void
    {
        $TopicSubscription = TopicSubscription::factory()->create();

        $response = $this->getJson('/api/topic_subscriptions/' . $TopicSubscription->id);
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

    public function test_can_update_TopicSubscription(): void
    {
        $TopicSubscription = TopicSubscription::factory()->create();
        $data = ['name' => 'Updated TopicSubscription'];

        $response = $this->putJson('/api/topic_subscriptions/' . $TopicSubscription->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('topic_subscriptions', $data);
    }

    public function test_can_delete_TopicSubscription(): void
    {
        $TopicSubscription = TopicSubscription::factory()->create();

        $response = $this->deleteJson('/api/topic_subscriptions/' . $TopicSubscription->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('topic_subscriptions', ['id' => $TopicSubscription->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/topic_subscriptions', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
