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

    private $task;
    private $user;
    private $taskStatus;
    private $name;
    private $description;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->name = 'Тестовое имя таска';
        $this->description = 'Тестовое описание таска';
    }

    public function testIndexForUnauthorizedUsers()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertSessionHasNoErrors();
    /*     $response->assertOk(); */
    }

    public function testCreateForUnauthorizedUsers()
    {
        $response = $this->get(route('tasks.create'));
        $response->assertSessionHasNoErrors();
       /*  $response->assertForbidden(); */
    }

    public function testStoreForUnauthorizedUsers()
    {
        $response = $this->post(route('tasks.store'));
        $response->assertSessionHasNoErrors();
       /*  $response->assertForbidden(); */
    }

    public function testShowForUnauthorizedUsers()
    {
        $response = $this->get(route('tasks.show', $this->task));
        $response->assertSessionHasNoErrors();
      /*   $response->assertOk(); */
    }


    public function testEditForUnauthorizedUsers()
    {
        $response = $this->get(route('tasks.edit', $this->task));
        $response->assertSessionHasNoErrors();
       /*  $response->assertForbidden(); */
    }

    public function testUpdateForUnauthorizedUsers()
    {
        $response = $this->patch(route('tasks.update', $this->task));
        $response->assertSessionHasNoErrors();
       /*  $response->assertForbidden(); */
    }

    public function testDestroyForUnauthorizedUsers()
    {
        $response = $this->delete(route('tasks.destroy', $this->task));
        $response->assertSessionHasNoErrors();
       /*  $response->assertForbidden(); */
    }

    public function testIndexForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('tasks.index'));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
    }

    public function testCreateForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('tasks.create'));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
    }

    public function testStoreForAuthorizedUsers()
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

    public function testShowForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('tasks.show', $this->task));
        $response->assertSessionHasNoErrors();
        $response->assertSeeText([
                                $this->task->name,
                                $this->task->description
                                ]);
        $response->assertOk();
    }

    public function testEditForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('tasks.edit', $this->task));
        $response->assertSessionHasNoErrors();
        $response->assertSeeText([
                                $this->task->name,
                                $this->task->description
                                ]);
        $response->assertOk();
    }

    public function testUpdateForAuthorizedUsers()
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
        $currentTaskName = $this->task->name;
        $creator = User::where('id', $this->task->created_by_id)->first();
        $response = $this->actingAs($creator)
                         ->delete(route('tasks.destroy', $this->task));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('tasks', [
            'name' => $currentTaskName
        ]);
        $response->assertRedirect();
    }

/*     public function testDestroyForAuthorizedUserWhereHeIsNotTheCreator()
    {
        $currentTaskName = $this->task->name;
        $response = $this->actingAs($this->user)
                         ->delete(route('tasks.destroy', $this->task));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', [
            'name' => $currentTaskName
        ]);
        $response->assertForbidden();
    } */
}
