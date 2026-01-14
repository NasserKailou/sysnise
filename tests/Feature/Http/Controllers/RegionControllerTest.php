<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Region;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RegionController
 */
final class RegionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $regions = Region::factory()->count(3)->create();

        $response = $this->get(route('regions.index'));

        $response->assertOk();
        $response->assertViewIs('region.index');
        $response->assertViewHas('regions');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('regions.create'));

        $response->assertOk();
        $response->assertViewIs('region.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RegionController::class,
            'store',
            \App\Http\Requests\RegionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nom = fake()->word();
        $code = fake()->word();

        $response = $this->post(route('regions.store'), [
            'nom' => $nom,
            'code' => $code,
        ]);

        $regions = Region::query()
            ->where('nom', $nom)
            ->where('code', $code)
            ->get();
        $this->assertCount(1, $regions);
        $region = $regions->first();

        $response->assertRedirect(route('regions.index'));
        $response->assertSessionHas('region.id', $region->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $region = Region::factory()->create();

        $response = $this->get(route('regions.show', $region));

        $response->assertOk();
        $response->assertViewIs('region.show');
        $response->assertViewHas('region');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $region = Region::factory()->create();

        $response = $this->get(route('regions.edit', $region));

        $response->assertOk();
        $response->assertViewIs('region.edit');
        $response->assertViewHas('region');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RegionController::class,
            'update',
            \App\Http\Requests\RegionUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $region = Region::factory()->create();
        $nom = fake()->word();
        $code = fake()->word();

        $response = $this->put(route('regions.update', $region), [
            'nom' => $nom,
            'code' => $code,
        ]);

        $region->refresh();

        $response->assertRedirect(route('regions.index'));
        $response->assertSessionHas('region.id', $region->id);

        $this->assertEquals($nom, $region->nom);
        $this->assertEquals($code, $region->code);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $region = Region::factory()->create();

        $response = $this->delete(route('regions.destroy', $region));

        $response->assertRedirect(route('regions.index'));

        $this->assertModelMissing($region);
    }
}
