<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use Faker\Factory as Faker;

class TaskStatusControllerTest extends TestCase
{
    private TaskStatus $taskStatus;
    private User $user;
    private string $name;

    protected function setUp(): void
    {
        parent::setUp();
        $faker = Faker::create();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->user = User::factory()->create();
        $this->name = $faker->word;
    }

    public function testIndexForUnauthenticatedUsers()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testIndexForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreateForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testStoreForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('task_statuses.store'), ['name' => $this->name]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', [
            'name' => $this->name,
        ]);
        $response->assertRedirect();
    }

    public function testEditForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('task_statuses.edit', $this->taskStatus));

        $response->assertOk();
    }

    public function testUpdateForAuthenticatedUsers()
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

    public function testDestroyForAAuthenticatedUsers()
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
