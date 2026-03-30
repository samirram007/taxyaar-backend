<?php

namespace App\Modules\UserFollows\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\UserFollows\Models\UserFollows;

class UserFollowsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_user_follows(): void
    {
        $response = $this->getJson('/api/user_follows');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);
    }

    public function test_can_create_UserFollows(): void
    {
        $data = ['name' => 'Test UserFollows'];

        $response = $this->postJson('/api/user_follows', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('user_follows', $data);
    }

    public function test_can_show_UserFollows(): void
    {
        $UserFollows = UserFollows::factory()->create();

        $response = $this->getJson('/api/user_follows/' . $UserFollows->id);
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

    public function test_can_update_UserFollows(): void
    {
        $UserFollows = UserFollows::factory()->create();
        $data = ['name' => 'Updated UserFollows'];

        $response = $this->putJson('/api/user_follows/' . $UserFollows->id, $data);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseHas('user_follows', $data);
    }

    public function test_can_delete_UserFollows(): void
    {
        $UserFollows = UserFollows::factory()->create();

        $response = $this->deleteJson('/api/user_follows/' . $UserFollows->id);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'code',
                     'message'
                 ]);

        $this->assertDatabaseMissing('user_follows', ['id' => $UserFollows->id]);
    }

    public function test_validation_errors_on_create(): void
    {
        $response = $this->postJson('/api/user_follows', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}
