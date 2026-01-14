<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\TypeDesagregation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TypeDesagregationController
 */
final class TypeDesagregationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $typeDesagregations = TypeDesagregation::factory()->count(3)->create();

        $response = $this->get(route('type-desagregations.index'));

        $response->assertOk();
        $response->assertViewIs('typeDesagregation.index');
        $response->assertViewHas('typeDesagregations');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('type-desagregations.create'));

        $response->assertOk();
        $response->assertViewIs('typeDesagregation.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TypeDesagregationController::class,
            'store',
            \App\Http\Requests\TypeDesagregationStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();

        $response = $this->post(route('type-desagregations.store'), [
            'intitule' => $intitule,
        ]);

        $typeDesagregations = TypeDesagregation::query()
            ->where('intitule', $intitule)
            ->get();
        $this->assertCount(1, $typeDesagregations);
        $typeDesagregation = $typeDesagregations->first();

        $response->assertRedirect(route('typeDesagregations.index'));
        $response->assertSessionHas('typeDesagregation.id', $typeDesagregation->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $typeDesagregation = TypeDesagregation::factory()->create();

        $response = $this->get(route('type-desagregations.show', $typeDesagregation));

        $response->assertOk();
        $response->assertViewIs('typeDesagregation.show');
        $response->assertViewHas('typeDesagregation');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $typeDesagregation = TypeDesagregation::factory()->create();

        $response = $this->get(route('type-desagregations.edit', $typeDesagregation));

        $response->assertOk();
        $response->assertViewIs('typeDesagregation.edit');
        $response->assertViewHas('typeDesagregation');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TypeDesagregationController::class,
            'update',
            \App\Http\Requests\TypeDesagregationUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $typeDesagregation = TypeDesagregation::factory()->create();
        $intitule = fake()->word();

        $response = $this->put(route('type-desagregations.update', $typeDesagregation), [
            'intitule' => $intitule,
        ]);

        $typeDesagregation->refresh();

        $response->assertRedirect(route('typeDesagregations.index'));
        $response->assertSessionHas('typeDesagregation.id', $typeDesagregation->id);

        $this->assertEquals($intitule, $typeDesagregation->intitule);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $typeDesagregation = TypeDesagregation::factory()->create();

        $response = $this->delete(route('type-desagregations.destroy', $typeDesagregation));

        $response->assertRedirect(route('typeDesagregations.index'));

        $this->assertModelMissing($typeDesagregation);
    }
}
