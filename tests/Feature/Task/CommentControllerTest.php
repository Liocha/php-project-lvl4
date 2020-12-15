<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Task $task;
    private string $body;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
        $this->body = 'Тестовый контент сомментария';
    }


    public function testStoreForUnauthenticatedUsers()
    {
        $response = $this->post(
            route('tasks.comments.store', $this->task),
            [
                                                            'content' => $this->body
                                                            ]
        );
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function testStoreForAuthenticatedUsers()
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
