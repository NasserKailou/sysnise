<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CadreDeveloppement;
use App\Models\CadreDeveloppementPieceJointe;
use App\Models\PieceJointe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CadreDeveloppementPieceJointeController
 */
final class CadreDeveloppementPieceJointeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $cadreDeveloppementPieceJointes = CadreDeveloppementPieceJointe::factory()->count(3)->create();

        $response = $this->get(route('cadre-developpement-piece-jointes.index'));

        $response->assertOk();
        $response->assertViewIs('cadreDeveloppementPieceJointe.index');
        $response->assertViewHas('cadreDeveloppementPieceJointes');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('cadre-developpement-piece-jointes.create'));

        $response->assertOk();
        $response->assertViewIs('cadreDeveloppementPieceJointe.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CadreDeveloppementPieceJointeController::class,
            'store',
            \App\Http\Requests\CadreDeveloppementPieceJointeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $cadre_developpement = CadreDeveloppement::factory()->create();
        $piece_jointe = PieceJointe::factory()->create();

        $response = $this->post(route('cadre-developpement-piece-jointes.store'), [
            'cadre_developpement_id' => $cadre_developpement->id,
            'piece_jointe_id' => $piece_jointe->id,
        ]);

        $cadreDeveloppementPieceJointes = CadreDeveloppementPieceJointe::query()
            ->where('cadre_developpement_id', $cadre_developpement->id)
            ->where('piece_jointe_id', $piece_jointe->id)
            ->get();
        $this->assertCount(1, $cadreDeveloppementPieceJointes);
        $cadreDeveloppementPieceJointe = $cadreDeveloppementPieceJointes->first();

        $response->assertRedirect(route('cadreDeveloppementPieceJointes.index'));
        $response->assertSessionHas('cadreDeveloppementPieceJointe.id', $cadreDeveloppementPieceJointe->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $cadreDeveloppementPieceJointe = CadreDeveloppementPieceJointe::factory()->create();

        $response = $this->get(route('cadre-developpement-piece-jointes.show', $cadreDeveloppementPieceJointe));

        $response->assertOk();
        $response->assertViewIs('cadreDeveloppementPieceJointe.show');
        $response->assertViewHas('cadreDeveloppementPieceJointe');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $cadreDeveloppementPieceJointe = CadreDeveloppementPieceJointe::factory()->create();

        $response = $this->get(route('cadre-developpement-piece-jointes.edit', $cadreDeveloppementPieceJointe));

        $response->assertOk();
        $response->assertViewIs('cadreDeveloppementPieceJointe.edit');
        $response->assertViewHas('cadreDeveloppementPieceJointe');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CadreDeveloppementPieceJointeController::class,
            'update',
            \App\Http\Requests\CadreDeveloppementPieceJointeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $cadreDeveloppementPieceJointe = CadreDeveloppementPieceJointe::factory()->create();
        $cadre_developpement = CadreDeveloppement::factory()->create();
        $piece_jointe = PieceJointe::factory()->create();

        $response = $this->put(route('cadre-developpement-piece-jointes.update', $cadreDeveloppementPieceJointe), [
            'cadre_developpement_id' => $cadre_developpement->id,
            'piece_jointe_id' => $piece_jointe->id,
        ]);

        $cadreDeveloppementPieceJointe->refresh();

        $response->assertRedirect(route('cadreDeveloppementPieceJointes.index'));
        $response->assertSessionHas('cadreDeveloppementPieceJointe.id', $cadreDeveloppementPieceJointe->id);

        $this->assertEquals($cadre_developpement->id, $cadreDeveloppementPieceJointe->cadre_developpement_id);
        $this->assertEquals($piece_jointe->id, $cadreDeveloppementPieceJointe->piece_jointe_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $cadreDeveloppementPieceJointe = CadreDeveloppementPieceJointe::factory()->create();

        $response = $this->delete(route('cadre-developpement-piece-jointes.destroy', $cadreDeveloppementPieceJointe));

        $response->assertRedirect(route('cadreDeveloppementPieceJointes.index'));

        $this->assertModelMissing($cadreDeveloppementPieceJointe);
    }
}
