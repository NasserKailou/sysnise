<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Commune;
use App\Models\Departement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommuneController
 */
final class CommuneControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $communes = Commune::factory()->count(3)->create();

        $response = $this->get(route('communes.index'));

        $response->assertOk();
        $response->assertViewIs('commune.index');
        $response->assertViewHas('communes');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('communes.create'));

        $response->assertOk();
        $response->assertViewIs('commune.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommuneController::class,
            'store',
            \App\Http\Requests\CommuneStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nom = fake()->word();
        $code = fake()->word();
        $departement = Departement::factory()->create();

        $response = $this->post(route('communes.store'), [
            'nom' => $nom,
            'code' => $code,
            'departement_id' => $departement->id,
        ]);

        $communes = Commune::query()
            ->where('nom', $nom)
            ->where('code', $code)
            ->where('departement_id', $departement->id)
            ->get();
        $this->assertCount(1, $communes);
        $commune = $communes->first();

        $response->assertRedirect(route('communes.index'));
        $response->assertSessionHas('commune.id', $commune->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $commune = Commune::factory()->create();

        $response = $this->get(route('communes.show', $commune));

        $response->assertOk();
        $response->assertViewIs('commune.show');
        $response->assertViewHas('commune');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $commune = Commune::factory()->create();

        $response = $this->get(route('communes.edit', $commune));

        $response->assertOk();
        $response->assertViewIs('commune.edit');
        $response->assertViewHas('commune');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommuneController::class,
            'update',
            \App\Http\Requests\CommuneUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $commune = Commune::factory()->create();
        $nom = fake()->word();
        $code = fake()->word();
        $departement = Departement::factory()->create();

        $response = $this->put(route('communes.update', $commune), [
            'nom' => $nom,
            'code' => $code,
            'departement_id' => $departement->id,
        ]);

        $commune->refresh();

        $response->assertRedirect(route('communes.index'));
        $response->assertSessionHas('commune.id', $commune->id);

        $this->assertEquals($nom, $commune->nom);
        $this->assertEquals($code, $commune->code);
        $this->assertEquals($departement->id, $commune->departement_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $commune = Commune::factory()->create();

        $response = $this->delete(route('communes.destroy', $commune));

        $response->assertRedirect(route('communes.index'));

        $this->assertModelMissing($commune);
    }
}
