<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Desagregation;
use App\Models\DonneeIndicateur;
use App\Models\Indicateur;
use App\Models\NatureDonnee;
use App\Models\Periode;
use App\Models\SourceIndicateur;
use App\Models\UniteIndicateur;
use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DonneeIndicateurController
 */
final class DonneeIndicateurControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $donneeIndicateurs = DonneeIndicateur::factory()->count(3)->create();

        $response = $this->get(route('donnee-indicateurs.index'));

        $response->assertOk();
        $response->assertViewIs('donneeIndicateur.index');
        $response->assertViewHas('donneeIndicateurs');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('donnee-indicateurs.create'));

        $response->assertOk();
        $response->assertViewIs('donneeIndicateur.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DonneeIndicateurController::class,
            'store',
            \App\Http\Requests\DonneeIndicateurStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nature_donnee = NatureDonnee::factory()->create();
        $indicateur = Indicateur::factory()->create();
        $zone = Zone::factory()->create();
        $periode = Periode::factory()->create();
        $desagregation = Desagregation::factory()->create();
        $source_indicateur = SourceIndicateur::factory()->create();
        $unite_indicateur = UniteIndicateur::factory()->create();
        $valeur = fake()->randomFloat(/** double_attributes **/);

        $response = $this->post(route('donnee-indicateurs.store'), [
            'nature_donnee_id' => $nature_donnee->id,
            'indicateur_id' => $indicateur->id,
            'zone_id' => $zone->id,
            'periode_id' => $periode->id,
            'desagregation_id' => $desagregation->id,
            'source_indicateur_id' => $source_indicateur->id,
            'unite_indicateur_id' => $unite_indicateur->id,
            'valeur' => $valeur,
        ]);

        $donneeIndicateurs = DonneeIndicateur::query()
            ->where('nature_donnee_id', $nature_donnee->id)
            ->where('indicateur_id', $indicateur->id)
            ->where('zone_id', $zone->id)
            ->where('periode_id', $periode->id)
            ->where('desagregation_id', $desagregation->id)
            ->where('source_indicateur_id', $source_indicateur->id)
            ->where('unite_indicateur_id', $unite_indicateur->id)
            ->where('valeur', $valeur)
            ->get();
        $this->assertCount(1, $donneeIndicateurs);
        $donneeIndicateur = $donneeIndicateurs->first();

        $response->assertRedirect(route('donneeIndicateurs.index'));
        $response->assertSessionHas('donneeIndicateur.id', $donneeIndicateur->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $donneeIndicateur = DonneeIndicateur::factory()->create();

        $response = $this->get(route('donnee-indicateurs.show', $donneeIndicateur));

        $response->assertOk();
        $response->assertViewIs('donneeIndicateur.show');
        $response->assertViewHas('donneeIndicateur');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $donneeIndicateur = DonneeIndicateur::factory()->create();

        $response = $this->get(route('donnee-indicateurs.edit', $donneeIndicateur));

        $response->assertOk();
        $response->assertViewIs('donneeIndicateur.edit');
        $response->assertViewHas('donneeIndicateur');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DonneeIndicateurController::class,
            'update',
            \App\Http\Requests\DonneeIndicateurUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $donneeIndicateur = DonneeIndicateur::factory()->create();
        $nature_donnee = NatureDonnee::factory()->create();
        $indicateur = Indicateur::factory()->create();
        $zone = Zone::factory()->create();
        $periode = Periode::factory()->create();
        $desagregation = Desagregation::factory()->create();
        $source_indicateur = SourceIndicateur::factory()->create();
        $unite_indicateur = UniteIndicateur::factory()->create();
        $valeur = fake()->randomFloat(/** double_attributes **/);

        $response = $this->put(route('donnee-indicateurs.update', $donneeIndicateur), [
            'nature_donnee_id' => $nature_donnee->id,
            'indicateur_id' => $indicateur->id,
            'zone_id' => $zone->id,
            'periode_id' => $periode->id,
            'desagregation_id' => $desagregation->id,
            'source_indicateur_id' => $source_indicateur->id,
            'unite_indicateur_id' => $unite_indicateur->id,
            'valeur' => $valeur,
        ]);

        $donneeIndicateur->refresh();

        $response->assertRedirect(route('donneeIndicateurs.index'));
        $response->assertSessionHas('donneeIndicateur.id', $donneeIndicateur->id);

        $this->assertEquals($nature_donnee->id, $donneeIndicateur->nature_donnee_id);
        $this->assertEquals($indicateur->id, $donneeIndicateur->indicateur_id);
        $this->assertEquals($zone->id, $donneeIndicateur->zone_id);
        $this->assertEquals($periode->id, $donneeIndicateur->periode_id);
        $this->assertEquals($desagregation->id, $donneeIndicateur->desagregation_id);
        $this->assertEquals($source_indicateur->id, $donneeIndicateur->source_indicateur_id);
        $this->assertEquals($unite_indicateur->id, $donneeIndicateur->unite_indicateur_id);
        $this->assertEquals($valeur, $donneeIndicateur->valeur);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $donneeIndicateur = DonneeIndicateur::factory()->create();

        $response = $this->delete(route('donnee-indicateurs.destroy', $donneeIndicateur));

        $response->assertRedirect(route('donneeIndicateurs.index'));

        $this->assertModelMissing($donneeIndicateur);
    }
}
