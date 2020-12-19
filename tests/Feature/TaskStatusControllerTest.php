<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use TaskStatusSeeder;
use UserSeeder;

class TaskStatusControllerTest extends TestCase
{
    private User $user;
    private TaskStatus $taskStatus;
    private string $taskStatusId;
    private string $taskStatusName;
    private string $newTaskStatusName;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TaskStatusSeeder::class);
        $this->seed(UserSeeder::class);
        $this->user = User::find(1);
        $this->taskStatus = TaskStatus::find(1);
        $this->taskStatusId = $this->taskStatus->id;
        $this->taskStatusName = $this->taskStatus->name;
        $this->newTaskStatusName = TaskStatus::make()->get('name');
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }


    public function testCreate()
    {
        $response = $this->actingAs($this->user)
            ->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $response = $this->actingAs($this->user)
            ->post(route('task_statuses.store'), ['name' => $this->newTaskStatusName]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', [
            'name' => $this->taskStatusName,
        ]);
        $response->assertRedirect();
    }

    public function testEdit()
    {
        $response = $this->actingAs($this->user)
            ->get(route('task_statuses.edit', $this->taskStatus));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $response = $this->actingAs($this->user)
            ->patch(route('task_statuses.update', $this->taskStatus), ['name' => $this->newTaskStatusName]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('task_statuses', [
            'name' => $this->taskStatusName
        ]);
        $this->assertDatabaseHas('task_statuses', [
            'name' => $this->newTaskStatusName,
        ]);
        $response->assertRedirect();
    }

    public function testDestroy()
    {
        $response = $this->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $this->taskStatus));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('task_statuses', [
            'id' => $this->taskStatusId
        ]);
        $response->assertRedirect();
    }
}
