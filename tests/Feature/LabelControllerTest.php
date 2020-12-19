<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use Illuminate\Foundation\Testing\WithFaker;
use LabelSeeder;
use UserSeeder;

class LabelControllerTest extends TestCase
{
    use WithFaker;

    private Label $label;
    private array $labalAttributes;
    private User $user;
    private array $newlabalAttributes;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LabelSeeder::class);
        $this->seed(UserSeeder::class);
        $this->label = Label::find(1);
        $this->labalAttributes = $this->label->only(['name', 'description']);
        $this->user = User::find(1);
        $this->newlabalAttributes = Label::factory()->make()->only(['name', 'description']);
        ;
    }

    public function testIndex()
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), $this->newlabalAttributes);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $this->newlabalAttributes);
        $response->assertRedirect();
    }

    public function testEdit()
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.edit', $this->label));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $response = $this->actingAs($this->user)
            ->patch(
                route('labels.update', $this->label),
                $this->newlabalAttributes
            );
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('labels', $this->labalAttributes);
        $this->assertDatabaseHas('labels', $this->newlabalAttributes);
        $response->assertRedirect();
    }

    public function testDestroy()
    {
        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', $this->label));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('labels', $this->labalAttributes);
        $response->assertRedirect();
    }
}
