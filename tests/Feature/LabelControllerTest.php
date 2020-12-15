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

    public function testIndexForUnauthenticatedUsers()
    {
        $response = $this->get(route('labels.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSeeText($this->label->name);
        $response->assertSeeText($this->label->description);
        $response->assertOk();
    }

    public function testCreateForUnauthenticatedUsers()
    {
        $response = $this->get(route('labels.create'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function testStoreForUnauthenticatedUsers()
    {
        $response = $this->post(route('labels.store'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function testEditForUnauthenticatedUsers()
    {
        $response = $this->get(route('labels.edit', $this->label));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function testUpdateForUnauthenticatedUsers()
    {
        $response = $this->patch(route('labels.update', $this->label));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function testDestroyForUnauthenticatedUsers()
    {
        $response = $this->delete(route('labels.destroy', $this->label));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function testIndexForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('labels.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSeeText($this->label->name);
        $response->assertSeeText($this->label->description);
        $response->assertOk();
    }

    public function testCreateForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('labels.create'));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
    }

    public function testStoreForAuthenticatedUsers()
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

    public function testEditForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('labels.edit', $this->label));
        $response->assertSessionHasNoErrors();
        $response->assertSee($this->label->name);
        $response->assertSee($this->label->description);
        $response->assertOk();
    }

    public function testUpdateForAuthenticatedUsers()
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

    public function testDestroyForAuthenticatedUsers()
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
