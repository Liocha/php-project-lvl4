<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;

class TaskStatusControllerTest extends TestCase
{
    private $taskStatus;
    private $user;
    private $name;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskStatus = TaskStatus::factory()->create();
        $this->user = User::factory()->create();
        $this->name = 'test status name';
    }

    public function testIndexForUnauthorizedUsers()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSeeText($this->taskStatus->name);
        $response->assertSeeText($this->taskStatus->description);
        $response->assertOk();
    }

    public function testCreateForUnauthorizedUsers()
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertSessionHasNoErrors();
        $response->assertForbidden();
    }

    public function testStoreForUnauthorizedUsers()
    {
        $response = $this->post(route('task_statuses.store'));
        $response->assertSessionHasNoErrors();
        $response->assertForbidden();
    }

    public function testEditForUnauthorizedUsers()
    {
        $response = $this->get(route('task_statuses.edit', $this->taskStatus));
        $response->assertSessionHasNoErrors();
        $response->assertForbidden();
    }

    public function testUpdateForUnauthorizedUsers()
    {
        $response = $this->patch(route('task_statuses.update', $this->taskStatus));
        $response->assertSessionHasNoErrors();
        $response->assertForbidden();
    }

    public function testDestroyForUnauthorizedUsers()
    {
        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));
        $response->assertSessionHasNoErrors();
        $response->assertForbidden();
    }

    public function testIndexForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('task_statuses.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSeeText($this->taskStatus->name);
        $response->assertSeeText($this->taskStatus->description);
        $response->assertOk();
    }

    public function testCreateForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('task_statuses.create'));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
    }

    public function testStoreForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('task_statuses.store'), ['name' => $this->name]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', [
            'name' => $this->name,
        ]);
        $response->assertRedirect();
    }

    public function testEditForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('task_statuses.edit', $this->taskStatus));
        $response->assertSessionHasNoErrors();
        $response->assertSee($this->taskStatus->name);
        $response->assertOk();
    }

    public function testUpdateForAuthorizedUsers()
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

    public function testDestroyForAauthorizedUsers()
    {
        $currentStatusName = $this->taskStatus->name;
        $response = $this->actingAs($this->user)
                         ->delete(route('task_statuses.destroy', $this->taskStatus));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('task_statuses', [
            'name' => $currentStatusName
        ]);
        $response->assertRedirect();
    }
}
