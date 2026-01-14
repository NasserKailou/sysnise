<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CommentaireValeurIndicateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommentaireValeurIndicateurController
 */
final class CommentaireValeurIndicateurControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $commentaireValeurIndicateurs = CommentaireValeurIndicateur::factory()->count(3)->create();

        $response = $this->get(route('commentaire-valeur-indicateurs.index'));

        $response->assertOk();
        $response->assertViewIs('commentaireValeurIndicateur.index');
        $response->assertViewHas('commentaireValeurIndicateurs');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('commentaire-valeur-indicateurs.create'));

        $response->assertOk();
        $response->assertViewIs('commentaireValeurIndicateur.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommentaireValeurIndicateurController::class,
            'store',
            \App\Http\Requests\CommentaireValeurIndicateurStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();

        $response = $this->post(route('commentaire-valeur-indicateurs.store'), [
            'intitule' => $intitule,
        ]);

        $commentaireValeurIndicateurs = CommentaireValeurIndicateur::query()
            ->where('intitule', $intitule)
            ->get();
        $this->assertCount(1, $commentaireValeurIndicateurs);
        $commentaireValeurIndicateur = $commentaireValeurIndicateurs->first();

        $response->assertRedirect(route('commentaireValeurIndicateurs.index'));
        $response->assertSessionHas('commentaireValeurIndicateur.id', $commentaireValeurIndicateur->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $commentaireValeurIndicateur = CommentaireValeurIndicateur::factory()->create();

        $response = $this->get(route('commentaire-valeur-indicateurs.show', $commentaireValeurIndicateur));

        $response->assertOk();
        $response->assertViewIs('commentaireValeurIndicateur.show');
        $response->assertViewHas('commentaireValeurIndicateur');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $commentaireValeurIndicateur = CommentaireValeurIndicateur::factory()->create();

        $response = $this->get(route('commentaire-valeur-indicateurs.edit', $commentaireValeurIndicateur));

        $response->assertOk();
        $response->assertViewIs('commentaireValeurIndicateur.edit');
        $response->assertViewHas('commentaireValeurIndicateur');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommentaireValeurIndicateurController::class,
            'update',
            \App\Http\Requests\CommentaireValeurIndicateurUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $commentaireValeurIndicateur = CommentaireValeurIndicateur::factory()->create();
        $intitule = fake()->word();

        $response = $this->put(route('commentaire-valeur-indicateurs.update', $commentaireValeurIndicateur), [
            'intitule' => $intitule,
        ]);

        $commentaireValeurIndicateur->refresh();

        $response->assertRedirect(route('commentaireValeurIndicateurs.index'));
        $response->assertSessionHas('commentaireValeurIndicateur.id', $commentaireValeurIndicateur->id);

        $this->assertEquals($intitule, $commentaireValeurIndicateur->intitule);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $commentaireValeurIndicateur = CommentaireValeurIndicateur::factory()->create();

        $response = $this->delete(route('commentaire-valeur-indicateurs.destroy', $commentaireValeurIndicateur));

        $response->assertRedirect(route('commentaireValeurIndicateurs.index'));

        $this->assertModelMissing($commentaireValeurIndicateur);
    }
}
