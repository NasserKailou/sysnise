<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CadreDeveloppement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CadreDeveloppementController
 */
final class CadreDeveloppementControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $cadreDeveloppements = CadreDeveloppement::factory()->count(3)->create();

        $response = $this->get(route('cadre-developpements.index'));

        $response->assertOk();
        $response->assertViewIs('cadreDeveloppement.index');
        $response->assertViewHas('cadreDeveloppements');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('cadre-developpements.create'));

        $response->assertOk();
        $response->assertViewIs('cadreDeveloppement.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CadreDeveloppementController::class,
            'store',
            \App\Http\Requests\CadreDeveloppementStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();

        $response = $this->post(route('cadre-developpements.store'), [
            'intitule' => $intitule,
        ]);

        $cadreDeveloppements = CadreDeveloppement::query()
            ->where('intitule', $intitule)
            ->get();
        $this->assertCount(1, $cadreDeveloppements);
        $cadreDeveloppement = $cadreDeveloppements->first();

        $response->assertRedirect(route('cadreDeveloppements.index'));
        $response->assertSessionHas('cadreDeveloppement.id', $cadreDeveloppement->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $cadreDeveloppement = CadreDeveloppement::factory()->create();

        $response = $this->get(route('cadre-developpements.show', $cadreDeveloppement));

        $response->assertOk();
        $response->assertViewIs('cadreDeveloppement.show');
        $response->assertViewHas('cadreDeveloppement');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $cadreDeveloppement = CadreDeveloppement::factory()->create();

        $response = $this->get(route('cadre-developpements.edit', $cadreDeveloppement));

        $response->assertOk();
        $response->assertViewIs('cadreDeveloppement.edit');
        $response->assertViewHas('cadreDeveloppement');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CadreDeveloppementController::class,
            'update',
            \App\Http\Requests\CadreDeveloppementUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $cadreDeveloppement = CadreDeveloppement::factory()->create();
        $intitule = fake()->word();

        $response = $this->put(route('cadre-developpements.update', $cadreDeveloppement), [
            'intitule' => $intitule,
        ]);

        $cadreDeveloppement->refresh();

        $response->assertRedirect(route('cadreDeveloppements.index'));
        $response->assertSessionHas('cadreDeveloppement.id', $cadreDeveloppement->id);

        $this->assertEquals($intitule, $cadreDeveloppement->intitule);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $cadreDeveloppement = CadreDeveloppement::factory()->create();

        $response = $this->delete(route('cadre-developpements.destroy', $cadreDeveloppement));

        $response->assertRedirect(route('cadreDeveloppements.index'));

        $this->assertModelMissing($cadreDeveloppement);
    }
}
