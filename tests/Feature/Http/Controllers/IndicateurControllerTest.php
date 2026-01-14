<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Indicateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\IndicateurController
 */
final class IndicateurControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $indicateurs = Indicateur::factory()->count(3)->create();

        $response = $this->get(route('indicateurs.index'));

        $response->assertOk();
        $response->assertViewIs('indicateur.index');
        $response->assertViewHas('indicateurs');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('indicateurs.create'));

        $response->assertOk();
        $response->assertViewIs('indicateur.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IndicateurController::class,
            'store',
            \App\Http\Requests\IndicateurStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();

        $response = $this->post(route('indicateurs.store'), [
            'intitule' => $intitule,
        ]);

        $indicateurs = Indicateur::query()
            ->where('intitule', $intitule)
            ->get();
        $this->assertCount(1, $indicateurs);
        $indicateur = $indicateurs->first();

        $response->assertRedirect(route('indicateurs.index'));
        $response->assertSessionHas('indicateur.id', $indicateur->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $indicateur = Indicateur::factory()->create();

        $response = $this->get(route('indicateurs.show', $indicateur));

        $response->assertOk();
        $response->assertViewIs('indicateur.show');
        $response->assertViewHas('indicateur');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $indicateur = Indicateur::factory()->create();

        $response = $this->get(route('indicateurs.edit', $indicateur));

        $response->assertOk();
        $response->assertViewIs('indicateur.edit');
        $response->assertViewHas('indicateur');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IndicateurController::class,
            'update',
            \App\Http\Requests\IndicateurUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $indicateur = Indicateur::factory()->create();
        $intitule = fake()->word();

        $response = $this->put(route('indicateurs.update', $indicateur), [
            'intitule' => $intitule,
        ]);

        $indicateur->refresh();

        $response->assertRedirect(route('indicateurs.index'));
        $response->assertSessionHas('indicateur.id', $indicateur->id);

        $this->assertEquals($intitule, $indicateur->intitule);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $indicateur = Indicateur::factory()->create();

        $response = $this->delete(route('indicateurs.destroy', $indicateur));

        $response->assertRedirect(route('indicateurs.index'));

        $this->assertModelMissing($indicateur);
    }
}
