<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Departement;
use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DepartementController
 */
final class DepartementControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $departements = Departement::factory()->count(3)->create();

        $response = $this->get(route('departements.index'));

        $response->assertOk();
        $response->assertViewIs('departement.index');
        $response->assertViewHas('departements');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('departements.create'));

        $response->assertOk();
        $response->assertViewIs('departement.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DepartementController::class,
            'store',
            \App\Http\Requests\DepartementStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nom = fake()->word();
        $code = fake()->word();
        $region = Region::factory()->create();

        $response = $this->post(route('departements.store'), [
            'nom' => $nom,
            'code' => $code,
            'region_id' => $region->id,
        ]);

        $departements = Departement::query()
            ->where('nom', $nom)
            ->where('code', $code)
            ->where('region_id', $region->id)
            ->get();
        $this->assertCount(1, $departements);
        $departement = $departements->first();

        $response->assertRedirect(route('departements.index'));
        $response->assertSessionHas('departement.id', $departement->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $departement = Departement::factory()->create();

        $response = $this->get(route('departements.show', $departement));

        $response->assertOk();
        $response->assertViewIs('departement.show');
        $response->assertViewHas('departement');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $departement = Departement::factory()->create();

        $response = $this->get(route('departements.edit', $departement));

        $response->assertOk();
        $response->assertViewIs('departement.edit');
        $response->assertViewHas('departement');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DepartementController::class,
            'update',
            \App\Http\Requests\DepartementUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $departement = Departement::factory()->create();
        $nom = fake()->word();
        $code = fake()->word();
        $region = Region::factory()->create();

        $response = $this->put(route('departements.update', $departement), [
            'nom' => $nom,
            'code' => $code,
            'region_id' => $region->id,
        ]);

        $departement->refresh();

        $response->assertRedirect(route('departements.index'));
        $response->assertSessionHas('departement.id', $departement->id);

        $this->assertEquals($nom, $departement->nom);
        $this->assertEquals($code, $departement->code);
        $this->assertEquals($region->id, $departement->region_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $departement = Departement::factory()->create();

        $response = $this->delete(route('departements.destroy', $departement));

        $response->assertRedirect(route('departements.index'));

        $this->assertModelMissing($departement);
    }
}
