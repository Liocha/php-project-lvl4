<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Faker\Factory as Faker;

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
        $faker = Faker::create();
        $this->body = $faker->paragraph;
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
