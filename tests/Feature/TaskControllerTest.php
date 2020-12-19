<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private Task $task;
    private array $taskAttributes;
    private User $taskCreator;
    private TaskStatus $taskStatus;
    private array $newTaskAttributes;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->task = Task::find(1);
        $this->taskAttributes = $this->task->only(['id', 'name', 'description', 'status_id']);
        $this->taskCreator = $this->task->creator;
        $this->taskStatus = TaskStatus::find(1);
        $this->newTaskAttributes = Task::factory()->make([
            'status_id' => $this->taskStatus->id,
        ])->only(['name', 'description', 'status_id']);
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->taskCreator)
            ->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $response = $this->actingAs($this->taskCreator)->post(
            route('tasks.store'),
            $this->newTaskAttributes
        );
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $this->newTaskAttributes);
        $response->assertRedirect();
    }

    public function testShow()
    {
        $response = $this->actingAs($this->taskCreator)
            ->get(route('tasks.show', $this->task));
        $response->assertOk();
    }

    public function testEdit()
    {
        $response = $this->actingAs($this->taskCreator)
            ->get(route('tasks.edit', $this->task));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $response = $this->actingAs($this->taskCreator)
            ->patch(
                route('tasks.update', $this->task),
                $this->newTaskAttributes
            );
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('tasks', $this->taskAttributes);
        $this->assertDatabaseHas('tasks', $this->newTaskAttributes);
        $response->assertRedirect();
    }

    public function testDestroy()
    {
        $response = $this->actingAs($this->taskCreator)
            ->delete(route('tasks.destroy', $this->task));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('tasks', $this->taskAttributes);
        $response->assertRedirect();
    }
}
