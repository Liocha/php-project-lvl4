<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private User $user;
    private Task $task;
    private string $body;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
        $this->body = $this->faker->paragraph();
    }

    public function testStore()
    {
        $response = $this->actingAs($this->user)
            ->post(
                route('tasks.comments.store', $this->task),
                [
                    'body' => $this->body,
                ]
            );
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('comments', [
            'body' => $this->body,
            'created_by_id' => $this->user->id,
            'task_id' => $this->task->id,
        ]);
        $response->assertRedirect();
    }
}
