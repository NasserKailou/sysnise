<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Commune;
use App\Models\Localite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LocaliteController
 */
final class LocaliteControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $localites = Localite::factory()->count(3)->create();

        $response = $this->get(route('localites.index'));

        $response->assertOk();
        $response->assertViewIs('localite.index');
        $response->assertViewHas('localites');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('localites.create'));

        $response->assertOk();
        $response->assertViewIs('localite.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LocaliteController::class,
            'store',
            \App\Http\Requests\LocaliteStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nom = fake()->word();
        $code = fake()->word();
        $commune = Commune::factory()->create();

        $response = $this->post(route('localites.store'), [
            'nom' => $nom,
            'code' => $code,
            'commune_id' => $commune->id,
        ]);

        $localites = Localite::query()
            ->where('nom', $nom)
            ->where('code', $code)
            ->where('commune_id', $commune->id)
            ->get();
        $this->assertCount(1, $localites);
        $localite = $localites->first();

        $response->assertRedirect(route('localites.index'));
        $response->assertSessionHas('localite.id', $localite->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $localite = Localite::factory()->create();

        $response = $this->get(route('localites.show', $localite));

        $response->assertOk();
        $response->assertViewIs('localite.show');
        $response->assertViewHas('localite');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $localite = Localite::factory()->create();

        $response = $this->get(route('localites.edit', $localite));

        $response->assertOk();
        $response->assertViewIs('localite.edit');
        $response->assertViewHas('localite');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LocaliteController::class,
            'update',
            \App\Http\Requests\LocaliteUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $localite = Localite::factory()->create();
        $nom = fake()->word();
        $code = fake()->word();
        $commune = Commune::factory()->create();

        $response = $this->put(route('localites.update', $localite), [
            'nom' => $nom,
            'code' => $code,
            'commune_id' => $commune->id,
        ]);

        $localite->refresh();

        $response->assertRedirect(route('localites.index'));
        $response->assertSessionHas('localite.id', $localite->id);

        $this->assertEquals($nom, $localite->nom);
        $this->assertEquals($code, $localite->code);
        $this->assertEquals($commune->id, $localite->commune_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $localite = Localite::factory()->create();

        $response = $this->delete(route('localites.destroy', $localite));

        $response->assertRedirect(route('localites.index'));

        $this->assertModelMissing($localite);
    }
}
