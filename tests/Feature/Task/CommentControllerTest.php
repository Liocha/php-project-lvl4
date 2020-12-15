<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
        $this->content = 'Тестовый контент сомментария';
    }


    public function testStoreForUnauthenticatedUsers()
    {
        $response = $this->post(
            route('tasks.comments.store', $this->task),
            [
                                                            'content' => $this->content
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
                                    'content' => $this->content,
                             ]
                         );
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('comments', [
            'content' => $this->content,
            'created_by_id' => $this->user->id,
            'task_id' => $this->task->id,
        ]);
        $response->assertRedirect();
    }
}
