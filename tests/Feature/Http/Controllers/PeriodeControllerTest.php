<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Periode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PeriodeController
 */
final class PeriodeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $periodes = Periode::factory()->count(3)->create();

        $response = $this->get(route('periodes.index'));

        $response->assertOk();
        $response->assertViewIs('periode.index');
        $response->assertViewHas('periodes');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('periodes.create'));

        $response->assertOk();
        $response->assertViewIs('periode.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PeriodeController::class,
            'store',
            \App\Http\Requests\PeriodeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $intitule = fake()->word();

        $response = $this->post(route('periodes.store'), [
            'intitule' => $intitule,
        ]);

        $periodes = Periode::query()
            ->where('intitule', $intitule)
            ->get();
        $this->assertCount(1, $periodes);
        $periode = $periodes->first();

        $response->assertRedirect(route('periodes.index'));
        $response->assertSessionHas('periode.id', $periode->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $periode = Periode::factory()->create();

        $response = $this->get(route('periodes.show', $periode));

        $response->assertOk();
        $response->assertViewIs('periode.show');
        $response->assertViewHas('periode');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $periode = Periode::factory()->create();

        $response = $this->get(route('periodes.edit', $periode));

        $response->assertOk();
        $response->assertViewIs('periode.edit');
        $response->assertViewHas('periode');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PeriodeController::class,
            'update',
            \App\Http\Requests\PeriodeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $periode = Periode::factory()->create();
        $intitule = fake()->word();

        $response = $this->put(route('periodes.update', $periode), [
            'intitule' => $intitule,
        ]);

        $periode->refresh();

        $response->assertRedirect(route('periodes.index'));
        $response->assertSessionHas('periode.id', $periode->id);

        $this->assertEquals($intitule, $periode->intitule);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $periode = Periode::factory()->create();

        $response = $this->delete(route('periodes.destroy', $periode));

        $response->assertRedirect(route('periodes.index'));

        $this->assertModelMissing($periode);
    }
}
