<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\WithFaker;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private Task $task;
    private User $user;
    private TaskStatus $taskStatus;
    private string $name;
    private string $description;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->name = $this->faker->word();
        $this->description = $this->faker->paragraph();
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)
            ->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $response = $this->actingAs($this->user)->post(
            route('tasks.store'),
            [
                'name' => $this->name,
                'description' => $this->description,
                'status_id' => $this->taskStatus->id,
                'assigned_to_id' => $this->user->id,
            ]
        );
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', [
            'name' => $this->name,
            'description' => $this->description,
            'status_id' => $this->taskStatus->id,
            'assigned_to_id' => $this->user->id
        ]);
        $response->assertRedirect();
    }

    public function testShow()
    {
        $response = $this->actingAs($this->user)
            ->get(route('tasks.show', $this->task));
        $response->assertSeeText([
            $this->task->name,
            $this->task->description
        ]);
        $response->assertOk();
    }

    public function testEdit()
    {
        $response = $this->actingAs($this->user)
            ->get(route('tasks.edit', $this->task));
        $response->assertSeeText([
            $this->task->name,
            $this->task->description
        ]);
        $response->assertOk();
    }

    public function testUpdate()
    {
        $currentTaskName = $this->task->name;
        $currentTaskDescription = $this->task->description;

        $response = $this->actingAs($this->user)
            ->patch(
                route('tasks.update', $this->task),
                [
                    'name' => $this->name,
                    'description' => $this->description,
                    'status_id' => $this->taskStatus->id,
                    'assigned_to_id' => $this->user->id,
                ]
            );
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('tasks', [
            'name' => $currentTaskName,
            'description' => $currentTaskDescription
        ]);
        $this->assertDatabaseHas('tasks', [
            'name' => $this->name,
            'description' => $this->description,
            'status_id' => $this->taskStatus->id,
            'assigned_to_id' => $this->user->id
        ]);
        $response->assertRedirect();
    }

    public function testDestroy()
    {

        $currentTaskId = $this->task->id;
        $creator = $this->task->creator;
        $response = $this->actingAs($creator)
            ->delete(route('tasks.destroy', $this->task));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('tasks', [
            'id' => $currentTaskId
        ]);
        $response->assertRedirect();
    }
}
