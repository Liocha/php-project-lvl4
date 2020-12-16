<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use Faker\Factory as Faker;

class LabelControllerTest extends TestCase
{
    private Label $label;
    private User $user;
    private string $name;
    private string $description;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label = Label::factory()->create();
        $this->user = User::factory()->create();
        $faker = Faker::create();
        $this->name = $faker->word;
        $this->description = $faker->paragraph;
    }

    public function testIndexForUnauthenticatedUsers()
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testIndexForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreateForAuthenticatedUsers()
    {
        $response = $this->actingAs($this->user)
                         ->get(route('labels.create'));
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
