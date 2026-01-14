<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PieceJointe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PieceJointeController
 */
final class PieceJointeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $pieceJointes = PieceJointe::factory()->count(3)->create();

        $response = $this->get(route('piece-jointes.index'));

        $response->assertOk();
        $response->assertViewIs('pieceJointe.index');
        $response->assertViewHas('pieceJointes');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('piece-jointes.create'));

        $response->assertOk();
        $response->assertViewIs('pieceJointe.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PieceJointeController::class,
            'store',
            \App\Http\Requests\PieceJointeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();
        $lien = fake()->word();

        $response = $this->post(route('piece-jointes.store'), [
            'intitule' => $intitule,
            'lien' => $lien,
        ]);

        $pieceJointes = PieceJointe::query()
            ->where('intitule', $intitule)
            ->where('lien', $lien)
            ->get();
        $this->assertCount(1, $pieceJointes);
        $pieceJointe = $pieceJointes->first();

        $response->assertRedirect(route('pieceJointes.index'));
        $response->assertSessionHas('pieceJointe.id', $pieceJointe->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $pieceJointe = PieceJointe::factory()->create();

        $response = $this->get(route('piece-jointes.show', $pieceJointe));

        $response->assertOk();
        $response->assertViewIs('pieceJointe.show');
        $response->assertViewHas('pieceJointe');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $pieceJointe = PieceJointe::factory()->create();

        $response = $this->get(route('piece-jointes.edit', $pieceJointe));

        $response->assertOk();
        $response->assertViewIs('pieceJointe.edit');
        $response->assertViewHas('pieceJointe');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PieceJointeController::class,
            'update',
            \App\Http\Requests\PieceJointeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $pieceJointe = PieceJointe::factory()->create();
        $intitule = fake()->word();
        $lien = fake()->word();

        $response = $this->put(route('piece-jointes.update', $pieceJointe), [
            'intitule' => $intitule,
            'lien' => $lien,
        ]);

        $pieceJointe->refresh();

        $response->assertRedirect(route('pieceJointes.index'));
        $response->assertSessionHas('pieceJointe.id', $pieceJointe->id);

        $this->assertEquals($intitule, $pieceJointe->intitule);
        $this->assertEquals($lien, $pieceJointe->lien);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $pieceJointe = PieceJointe::factory()->create();

        $response = $this->delete(route('piece-jointes.destroy', $pieceJointe));

        $response->assertRedirect(route('pieceJointes.index'));

        $this->assertModelMissing($pieceJointe);
    }
}
