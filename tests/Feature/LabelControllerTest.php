<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Label;

class LabelControllerTest extends TestCase
{
    private $label;
    private $user;
    private $name;
    private $description;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label = Label::factory()->create();
        $this->user = User::factory()->create();
        $this->name = 'test label name';
        $this->description = 'test label description';
    }

    public function testIndexForUnauthorizedUsers()
    {
        $response = $this->get(route('labels.index'));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
    }

    public function testCreateForUnauthorizedUsers()
    {
        $response = $this->get(route('labels.create'));
        $response->assertSessionHasNoErrors();
        $response->assertForbidden();
    }

    public function testStoreForUnauthorizedUsers()
    {
        $response = $this->post(route('labels.store'));
        $response->assertSessionHasNoErrors();
        $response->assertForbidden();
    }

    public function testEditForUnauthorizedUsers()
    {
        $response = $this->get(route('labels.edit', $this->label));
        $response->assertSessionHasNoErrors();
        $response->assertForbidden();
    }

    public function testUpdateForUnauthorizedUsers()
    {
        $response = $this->patch(route('labels.update', $this->label));
        $response->assertSessionHasNoErrors();
        $response->assertForbidden();
    }

    public function testDestroyForUnauthorizedUsers()
    {
        $response = $this->delete(route('labels.destroy', $this->label));
        $response->assertSessionHasNoErrors();
        $response->assertForbidden();
    }

    public function testIndexForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('labels.index'));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
    }

    public function testCreateForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('labels.create'));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
    }

    public function testStoreForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('labels.store'), [
                             'name' => $this->name,
                             'description' => $this->description
                             ]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', [
            'name' => $this->name,
            'description' => $this->description
        ]);
        $response->assertRedirect();
    }

    public function testEditForAuthorizedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('labels.edit', $this->label));
        $response->assertSessionHasNoErrors();
        $response->assertSee($this->label->name);
        $response->assertSee($this->label->description);
        $response->assertOk();
    }

    public function testUpdateForAuthorizedUsers()
    {
        $currentLabelName = $this->label->name;
        $currentLabelDescription = $this->label->description;
        $response = $this->actingAs($this->user)
                         ->patch(
                             route('labels.update', $this->label),
                             [
                                'name' => $this->name,
                                'description' => $this->description
                             ]
                         );
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('labels', [
            'name' => $currentLabelName,
            'description' => $currentLabelDescription
        ]);
        $this->assertDatabaseHas('labels', [
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $response->assertRedirect();
    }

    public function testDestroyForAauthorizedUsers()
    {
        $currentLabelName = $this->label->name;
        $currentLabelDescription = $this->label->description;
        $response = $this->actingAs($this->user)
                         ->delete(route('labels.destroy', $this->label));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('labels', [
            'name' => $currentLabelName,
            'description' => $currentLabelDescription
        ]);
        $response->assertRedirect();
    }
}
