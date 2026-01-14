<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\NatureDonnee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\NatureDonneeController
 */
final class NatureDonneeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $natureDonnees = NatureDonnee::factory()->count(3)->create();

        $response = $this->get(route('nature-donnees.index'));

        $response->assertOk();
        $response->assertViewIs('natureDonnee.index');
        $response->assertViewHas('natureDonnees');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('nature-donnees.create'));

        $response->assertOk();
        $response->assertViewIs('natureDonnee.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NatureDonneeController::class,
            'store',
            \App\Http\Requests\NatureDonneeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();

        $response = $this->post(route('nature-donnees.store'), [
            'intitule' => $intitule,
        ]);

        $natureDonnees = NatureDonnee::query()
            ->where('intitule', $intitule)
            ->get();
        $this->assertCount(1, $natureDonnees);
        $natureDonnee = $natureDonnees->first();

        $response->assertRedirect(route('natureDonnees.index'));
        $response->assertSessionHas('natureDonnee.id', $natureDonnee->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $natureDonnee = NatureDonnee::factory()->create();

        $response = $this->get(route('nature-donnees.show', $natureDonnee));

        $response->assertOk();
        $response->assertViewIs('natureDonnee.show');
        $response->assertViewHas('natureDonnee');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $natureDonnee = NatureDonnee::factory()->create();

        $response = $this->get(route('nature-donnees.edit', $natureDonnee));

        $response->assertOk();
        $response->assertViewIs('natureDonnee.edit');
        $response->assertViewHas('natureDonnee');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NatureDonneeController::class,
            'update',
            \App\Http\Requests\NatureDonneeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $natureDonnee = NatureDonnee::factory()->create();
        $intitule = fake()->word();

        $response = $this->put(route('nature-donnees.update', $natureDonnee), [
            'intitule' => $intitule,
        ]);

        $natureDonnee->refresh();

        $response->assertRedirect(route('natureDonnees.index'));
        $response->assertSessionHas('natureDonnee.id', $natureDonnee->id);

        $this->assertEquals($intitule, $natureDonnee->intitule);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $natureDonnee = NatureDonnee::factory()->create();

        $response = $this->delete(route('nature-donnees.destroy', $natureDonnee));

        $response->assertRedirect(route('natureDonnees.index'));

        $this->assertModelMissing($natureDonnee);
    }
}
