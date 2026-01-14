<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Desagregation;
use App\Models\TypeDesagregation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DesagregationController
 */
final class DesagregationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $desagregations = Desagregation::factory()->count(3)->create();

        $response = $this->get(route('desagregations.index'));

        $response->assertOk();
        $response->assertViewIs('desagregation.index');
        $response->assertViewHas('desagregations');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('desagregations.create'));

        $response->assertOk();
        $response->assertViewIs('desagregation.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DesagregationController::class,
            'store',
            \App\Http\Requests\DesagregationStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();
        $type_desagregation = TypeDesagregation::factory()->create();

        $response = $this->post(route('desagregations.store'), [
            'intitule' => $intitule,
            'type_desagregation_id' => $type_desagregation->id,
        ]);

        $desagregations = Desagregation::query()
            ->where('intitule', $intitule)
            ->where('type_desagregation_id', $type_desagregation->id)
            ->get();
        $this->assertCount(1, $desagregations);
        $desagregation = $desagregations->first();

        $response->assertRedirect(route('desagregations.index'));
        $response->assertSessionHas('desagregation.id', $desagregation->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $desagregation = Desagregation::factory()->create();

        $response = $this->get(route('desagregations.show', $desagregation));

        $response->assertOk();
        $response->assertViewIs('desagregation.show');
        $response->assertViewHas('desagregation');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $desagregation = Desagregation::factory()->create();

        $response = $this->get(route('desagregations.edit', $desagregation));

        $response->assertOk();
        $response->assertViewIs('desagregation.edit');
        $response->assertViewHas('desagregation');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DesagregationController::class,
            'update',
            \App\Http\Requests\DesagregationUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $desagregation = Desagregation::factory()->create();
        $intitule = fake()->word();
        $type_desagregation = TypeDesagregation::factory()->create();

        $response = $this->put(route('desagregations.update', $desagregation), [
            'intitule' => $intitule,
            'type_desagregation_id' => $type_desagregation->id,
        ]);

        $desagregation->refresh();

        $response->assertRedirect(route('desagregations.index'));
        $response->assertSessionHas('desagregation.id', $desagregation->id);

        $this->assertEquals($intitule, $desagregation->intitule);
        $this->assertEquals($type_desagregation->id, $desagregation->type_desagregation_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $desagregation = Desagregation::factory()->create();

        $response = $this->delete(route('desagregations.destroy', $desagregation));

        $response->assertRedirect(route('desagregations.index'));

        $this->assertModelMissing($desagregation);
    }
}
