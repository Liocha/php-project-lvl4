<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use Faker\Factory as Faker;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

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
        $faker = Faker::create();
        $this->name = $faker->word;
        $this->description = $faker->paragraph;
    }

    public function testIndexForUnauthenticatedUsers()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testIndexForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreateForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStoreForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->post(
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

    public function testShowForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('tasks.show', $this->task));
        $response->assertSeeText([
                                $this->task->name,
                                $this->task->description
                                ]);
        $response->assertOk();
    }

    public function testEditForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('tasks.edit', $this->task));
        $response->assertSeeText([
                                $this->task->name,
                                $this->task->description
                                ]);
        $response->assertOk();
    }

    public function testUpdateForAuthenticatedUsers()
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

    public function testDestroyForAuthorizedUsers()
    {

        $newTask = Task::factory()->create();
        $currentTaskName = $newTask->name;
        $creator = $newTask->creator;
        $response = $this->actingAs($creator)
                         ->delete(route('tasks.destroy', $newTask));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('tasks', [
            'name' => $currentTaskName
        ]);
        $response->assertRedirect();
    }

    public function testDestroyForAuthorizedUserWhereHeIsNotTheCreator()
    {
        $currentTaskName = $this->task->name;
        $response = $this->actingAs($this->user)
                         ->delete(route('tasks.destroy', $this->task));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', [
            'name' => $currentTaskName
        ]);
        $response->assertForbidden();
    }
}
