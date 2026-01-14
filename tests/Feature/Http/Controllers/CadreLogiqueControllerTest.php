<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CadreLogique;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CadreLogiqueController
 */
final class CadreLogiqueControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $cadreLogiques = CadreLogique::factory()->count(3)->create();

        $response = $this->get(route('cadre-logiques.index'));

        $response->assertOk();
        $response->assertViewIs('cadreLogique.index');
        $response->assertViewHas('cadreLogiques');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('cadre-logiques.create'));

        $response->assertOk();
        $response->assertViewIs('cadreLogique.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CadreLogiqueController::class,
            'store',
            \App\Http\Requests\CadreLogiqueStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();
        $niveau = fake()->numberBetween(-10000, 10000);

        $response = $this->post(route('cadre-logiques.store'), [
            'intitule' => $intitule,
            'niveau' => $niveau,
        ]);

        $cadreLogiques = CadreLogique::query()
            ->where('intitule', $intitule)
            ->where('niveau', $niveau)
            ->get();
        $this->assertCount(1, $cadreLogiques);
        $cadreLogique = $cadreLogiques->first();

        $response->assertRedirect(route('cadreLogiques.index'));
        $response->assertSessionHas('cadreLogique.id', $cadreLogique->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $cadreLogique = CadreLogique::factory()->create();

        $response = $this->get(route('cadre-logiques.show', $cadreLogique));

        $response->assertOk();
        $response->assertViewIs('cadreLogique.show');
        $response->assertViewHas('cadreLogique');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $cadreLogique = CadreLogique::factory()->create();

        $response = $this->get(route('cadre-logiques.edit', $cadreLogique));

        $response->assertOk();
        $response->assertViewIs('cadreLogique.edit');
        $response->assertViewHas('cadreLogique');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CadreLogiqueController::class,
            'update',
            \App\Http\Requests\CadreLogiqueUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $cadreLogique = CadreLogique::factory()->create();
        $intitule = fake()->word();
        $niveau = fake()->numberBetween(-10000, 10000);

        $response = $this->put(route('cadre-logiques.update', $cadreLogique), [
            'intitule' => $intitule,
            'niveau' => $niveau,
        ]);

        $cadreLogique->refresh();

        $response->assertRedirect(route('cadreLogiques.index'));
        $response->assertSessionHas('cadreLogique.id', $cadreLogique->id);

        $this->assertEquals($intitule, $cadreLogique->intitule);
        $this->assertEquals($niveau, $cadreLogique->niveau);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $cadreLogique = CadreLogique::factory()->create();

        $response = $this->delete(route('cadre-logiques.destroy', $cadreLogique));

        $response->assertRedirect(route('cadreLogiques.index'));

        $this->assertModelMissing($cadreLogique);
    }
}
