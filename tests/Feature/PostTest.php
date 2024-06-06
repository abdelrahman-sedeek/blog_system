<?php

// tests/Feature/PostTest.php
namespace Tests\Feature;
use App\Models\Post;

use App\Models\User;
use App\Models\Category;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_post()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $category = Category::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(201)->assertJsonStructure(['id', 'title', 'content', 'user_id', 'category_id']);
    }
    public function test_update_post()
    {

        $user = User::factory()->create();
     

        $category = Category::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id, 'category_id' => $category->id]);

        $updateData = ['title' => 'Updated Title'];

        $response = $this->actingAs($user)->putJson("/api/posts/{$post->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Updated Title']);
    }

    public function test_delete_post()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $category = Category::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id, 'category_id' => $category->id]);

        $response = $this->actingAs($user)->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

}

