<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use Illuminate\Foundation\Testing\WithFaker;

class LabelControllerTest extends TestCase
{
    use WithFaker;

    private Label $label;
    private User $user;
    private array $labelData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label = Label::factory()->create();
        $this->labalId = $this->label->id;
        $this->labalName = $this->label->name;
        $this->user = User::factory()->create();
        $this->labelData = ['name' => $this->faker->word(), 'description' => $this->faker->paragraph()];
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
            ->post(route('labels.store'), $this->labelData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $this->labelData);
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
                $this->labelData
            );
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('labels', [
            'id' => $this->labalName
        ]);
        $this->assertDatabaseHas('labels', $this->labelData);
        $response->assertRedirect();
    }

    public function testDestroy()
    {
        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', $this->label));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('labels', [
            'id' => $this->labalId
        ]);
        $response->assertRedirect();
    }
}
