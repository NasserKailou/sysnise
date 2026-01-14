<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\UniteIndicateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UniteIndicateurController
 */
final class UniteIndicateurControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $uniteIndicateurs = UniteIndicateur::factory()->count(3)->create();

        $response = $this->get(route('unite-indicateurs.index'));

        $response->assertOk();
        $response->assertViewIs('uniteIndicateur.index');
        $response->assertViewHas('uniteIndicateurs');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('unite-indicateurs.create'));

        $response->assertOk();
        $response->assertViewIs('uniteIndicateur.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UniteIndicateurController::class,
            'store',
            \App\Http\Requests\UniteIndicateurStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();

        $response = $this->post(route('unite-indicateurs.store'), [
            'intitule' => $intitule,
        ]);

        $uniteIndicateurs = UniteIndicateur::query()
            ->where('intitule', $intitule)
            ->get();
        $this->assertCount(1, $uniteIndicateurs);
        $uniteIndicateur = $uniteIndicateurs->first();

        $response->assertRedirect(route('uniteIndicateurs.index'));
        $response->assertSessionHas('uniteIndicateur.id', $uniteIndicateur->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $uniteIndicateur = UniteIndicateur::factory()->create();

        $response = $this->get(route('unite-indicateurs.show', $uniteIndicateur));

        $response->assertOk();
        $response->assertViewIs('uniteIndicateur.show');
        $response->assertViewHas('uniteIndicateur');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $uniteIndicateur = UniteIndicateur::factory()->create();

        $response = $this->get(route('unite-indicateurs.edit', $uniteIndicateur));

        $response->assertOk();
        $response->assertViewIs('uniteIndicateur.edit');
        $response->assertViewHas('uniteIndicateur');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UniteIndicateurController::class,
            'update',
            \App\Http\Requests\UniteIndicateurUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $uniteIndicateur = UniteIndicateur::factory()->create();
        $intitule = fake()->word();

        $response = $this->put(route('unite-indicateurs.update', $uniteIndicateur), [
            'intitule' => $intitule,
        ]);

        $uniteIndicateur->refresh();

        $response->assertRedirect(route('uniteIndicateurs.index'));
        $response->assertSessionHas('uniteIndicateur.id', $uniteIndicateur->id);

        $this->assertEquals($intitule, $uniteIndicateur->intitule);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $uniteIndicateur = UniteIndicateur::factory()->create();

        $response = $this->delete(route('unite-indicateurs.destroy', $uniteIndicateur));

        $response->assertRedirect(route('uniteIndicateurs.index'));

        $this->assertModelMissing($uniteIndicateur);
    }
}
