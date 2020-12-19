<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Task\Comment;
use CommentSeeder;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Task $task;
    private array $newCommentAttributes;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CommentSeeder::class);
        $this->user = User::find(1);
        $this->task = Task::find(1);
        $this->newCommentAttributes = Comment::factory()
            ->make(['created_by_id' => $this->user->id, 'task_id' => $this->task->id])
            ->only(['body', 'created_by_id', 'task_id']);
    }

    public function testStore()
    {
        $response = $this->actingAs($this->user)
            ->post(
                route('tasks.comments.store', $this->task),
                $this->newCommentAttributes
            );
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('comments', $this->newCommentAttributes);
        $response->assertRedirect();
    }
}
