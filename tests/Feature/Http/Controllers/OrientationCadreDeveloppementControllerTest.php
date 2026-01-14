<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CadreDeveloppement;
use App\Models\CadreLogique;
use App\Models\OrientationCadreDeveloppement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrientationCadreDeveloppementController
 */
final class OrientationCadreDeveloppementControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $orientationCadreDeveloppements = OrientationCadreDeveloppement::factory()->count(3)->create();

        $response = $this->get(route('orientation-cadre-developpements.index'));

        $response->assertOk();
        $response->assertViewIs('orientationCadreDeveloppement.index');
        $response->assertViewHas('orientationCadreDeveloppements');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('orientation-cadre-developpements.create'));

        $response->assertOk();
        $response->assertViewIs('orientationCadreDeveloppement.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrientationCadreDeveloppementController::class,
            'store',
            \App\Http\Requests\OrientationCadreDeveloppementStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();
        $cadre_developpement = CadreDeveloppement::factory()->create();
        $cadre_logique = CadreLogique::factory()->create();

        $response = $this->post(route('orientation-cadre-developpements.store'), [
            'intitule' => $intitule,
            'cadre_developpement_id' => $cadre_developpement->id,
            'cadre_logique_id' => $cadre_logique->id,
        ]);

        $orientationCadreDeveloppements = OrientationCadreDeveloppement::query()
            ->where('intitule', $intitule)
            ->where('cadre_developpement_id', $cadre_developpement->id)
            ->where('cadre_logique_id', $cadre_logique->id)
            ->get();
        $this->assertCount(1, $orientationCadreDeveloppements);
        $orientationCadreDeveloppement = $orientationCadreDeveloppements->first();

        $response->assertRedirect(route('orientationCadreDeveloppements.index'));
        $response->assertSessionHas('orientationCadreDeveloppement.id', $orientationCadreDeveloppement->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $orientationCadreDeveloppement = OrientationCadreDeveloppement::factory()->create();

        $response = $this->get(route('orientation-cadre-developpements.show', $orientationCadreDeveloppement));

        $response->assertOk();
        $response->assertViewIs('orientationCadreDeveloppement.show');
        $response->assertViewHas('orientationCadreDeveloppement');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $orientationCadreDeveloppement = OrientationCadreDeveloppement::factory()->create();

        $response = $this->get(route('orientation-cadre-developpements.edit', $orientationCadreDeveloppement));

        $response->assertOk();
        $response->assertViewIs('orientationCadreDeveloppement.edit');
        $response->assertViewHas('orientationCadreDeveloppement');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrientationCadreDeveloppementController::class,
            'update',
            \App\Http\Requests\OrientationCadreDeveloppementUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $orientationCadreDeveloppement = OrientationCadreDeveloppement::factory()->create();
        $intitule = fake()->word();
        $cadre_developpement = CadreDeveloppement::factory()->create();
        $cadre_logique = CadreLogique::factory()->create();

        $response = $this->put(route('orientation-cadre-developpements.update', $orientationCadreDeveloppement), [
            'intitule' => $intitule,
            'cadre_developpement_id' => $cadre_developpement->id,
            'cadre_logique_id' => $cadre_logique->id,
        ]);

        $orientationCadreDeveloppement->refresh();

        $response->assertRedirect(route('orientationCadreDeveloppements.index'));
        $response->assertSessionHas('orientationCadreDeveloppement.id', $orientationCadreDeveloppement->id);

        $this->assertEquals($intitule, $orientationCadreDeveloppement->intitule);
        $this->assertEquals($cadre_developpement->id, $orientationCadreDeveloppement->cadre_developpement_id);
        $this->assertEquals($cadre_logique->id, $orientationCadreDeveloppement->cadre_logique_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $orientationCadreDeveloppement = OrientationCadreDeveloppement::factory()->create();

        $response = $this->delete(route('orientation-cadre-developpements.destroy', $orientationCadreDeveloppement));

        $response->assertRedirect(route('orientationCadreDeveloppements.index'));

        $this->assertModelMissing($orientationCadreDeveloppement);
    }
}
