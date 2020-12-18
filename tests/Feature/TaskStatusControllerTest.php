<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\WithFaker;

class TaskStatusControllerTest extends TestCase
{
    use WithFaker;

    private TaskStatus $taskStatus;
    private User $user;
    private string $name;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->user = User::factory()->create();
        $this->name = $this->faker->word();
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
            ->post(route('task_statuses.store'), ['name' => $this->name]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', [
            'name' => $this->name,
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
        $currentStatusName = $this->taskStatus->name;
        $response = $this->actingAs($this->user)
            ->patch(route('task_statuses.update', $this->taskStatus), ['name' => $this->name]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('task_statuses', [
            'name' => $currentStatusName
        ]);
        $this->assertDatabaseHas('task_statuses', [
            'name' => $this->name,
        ]);
        $response->assertRedirect();
    }

    public function testDestroy()
    {
        $currentStatusId = $this->taskStatus->name;
        $response = $this->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $this->taskStatus));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('task_statuses', [
            'id' => $currentStatusId
        ]);
        $response->assertRedirect();
    }
}
