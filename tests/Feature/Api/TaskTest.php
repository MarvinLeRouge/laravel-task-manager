<?php

namespace Tests\Feature\Api;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_tasks(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(3)->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/tasks')
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/tasks', [
                'title'    => 'Apprendre Laravel',
                'status'   => 'todo',
                'priority' => 'high',
            ])
            ->assertStatus(201)
            ->assertJsonPath('data.title', 'Apprendre Laravel');
    }

    public function test_user_cannot_create_task_without_title(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/tasks', [
                'status'   => 'todo',
                'priority' => 'high',
            ])
            ->assertStatus(422);
    }

    public function test_user_can_update_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->putJson("/api/tasks/{$task->id}", [
                'title'    => 'Titre modifié',
                'status'   => 'done',
                'priority' => 'low',
            ])
            ->assertStatus(200)
            ->assertJsonPath('data.title', 'Titre modifié');
    }

    public function test_user_can_delete_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/tasks/{$task->id}")
            ->assertStatus(204);
    }
}