<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\category;
use App\Models\User;
class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_create_category()
    {
        $user = User::factory()->create();
         $categoryData = ['name' => 'Test Category'];

        $response =$this->actingAs($user, 'sanctum')
        ->postJson('/api/categories', $categoryData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
    }

    public function test_update_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $updateData = ['name' => 'Updated Category'];

        $response =$this->actingAs($user, 'sanctum')->putJson("/api/categories/{$category->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Updated Category']);
    }

    public function test_delete_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
