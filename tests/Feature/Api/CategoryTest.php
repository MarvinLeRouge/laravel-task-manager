<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_categories(): void
    {
        $user = User::factory()->create();
        Category::factory()->count(3)->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/categories')
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_category(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/categories', [
                'name'  => 'Travail',
                'color' => '#6366f1',
            ])
            ->assertStatus(201)
            ->assertJsonPath('data.name', 'Travail');
    }

    public function test_user_cannot_create_category_without_name(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/categories', ['color' => '#6366f1'])
            ->assertStatus(422);
    }

    public function test_user_can_delete_category(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/categories/{$category->id}")
            ->assertStatus(204);
    }
}