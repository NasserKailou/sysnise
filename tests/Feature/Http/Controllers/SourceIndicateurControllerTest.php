<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\SourceIndicateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SourceIndicateurController
 */
final class SourceIndicateurControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $sourceIndicateurs = SourceIndicateur::factory()->count(3)->create();

        $response = $this->get(route('source-indicateurs.index'));

        $response->assertOk();
        $response->assertViewIs('sourceIndicateur.index');
        $response->assertViewHas('sourceIndicateurs');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('source-indicateurs.create'));

        $response->assertOk();
        $response->assertViewIs('sourceIndicateur.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SourceIndicateurController::class,
            'store',
            \App\Http\Requests\SourceIndicateurStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();

        $response = $this->post(route('source-indicateurs.store'), [
            'intitule' => $intitule,
        ]);

        $sourceIndicateurs = SourceIndicateur::query()
            ->where('intitule', $intitule)
            ->get();
        $this->assertCount(1, $sourceIndicateurs);
        $sourceIndicateur = $sourceIndicateurs->first();

        $response->assertRedirect(route('sourceIndicateurs.index'));
        $response->assertSessionHas('sourceIndicateur.id', $sourceIndicateur->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $sourceIndicateur = SourceIndicateur::factory()->create();

        $response = $this->get(route('source-indicateurs.show', $sourceIndicateur));

        $response->assertOk();
        $response->assertViewIs('sourceIndicateur.show');
        $response->assertViewHas('sourceIndicateur');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $sourceIndicateur = SourceIndicateur::factory()->create();

        $response = $this->get(route('source-indicateurs.edit', $sourceIndicateur));

        $response->assertOk();
        $response->assertViewIs('sourceIndicateur.edit');
        $response->assertViewHas('sourceIndicateur');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SourceIndicateurController::class,
            'update',
            \App\Http\Requests\SourceIndicateurUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $sourceIndicateur = SourceIndicateur::factory()->create();
        $intitule = fake()->word();

        $response = $this->put(route('source-indicateurs.update', $sourceIndicateur), [
            'intitule' => $intitule,
        ]);

        $sourceIndicateur->refresh();

        $response->assertRedirect(route('sourceIndicateurs.index'));
        $response->assertSessionHas('sourceIndicateur.id', $sourceIndicateur->id);

        $this->assertEquals($intitule, $sourceIndicateur->intitule);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $sourceIndicateur = SourceIndicateur::factory()->create();

        $response = $this->delete(route('source-indicateurs.destroy', $sourceIndicateur));

        $response->assertRedirect(route('sourceIndicateurs.index'));

        $this->assertModelMissing($sourceIndicateur);
    }
}
