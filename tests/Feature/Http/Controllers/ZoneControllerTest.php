<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ZoneController
 */
final class ZoneControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $zones = Zone::factory()->count(3)->create();

        $response = $this->get(route('zones.index'));

        $response->assertOk();
        $response->assertViewIs('zone.index');
        $response->assertViewHas('zones');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('zones.create'));

        $response->assertOk();
        $response->assertViewIs('zone.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ZoneController::class,
            'store',
            \App\Http\Requests\ZoneStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nom = fake()->word();
        $niveau = fake()->numberBetween(-10000, 10000);

        $response = $this->post(route('zones.store'), [
            'nom' => $nom,
            'niveau' => $niveau,
        ]);

        $zones = Zone::query()
            ->where('nom', $nom)
            ->where('niveau', $niveau)
            ->get();
        $this->assertCount(1, $zones);
        $zone = $zones->first();

        $response->assertRedirect(route('zones.index'));
        $response->assertSessionHas('zone.id', $zone->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $zone = Zone::factory()->create();

        $response = $this->get(route('zones.show', $zone));

        $response->assertOk();
        $response->assertViewIs('zone.show');
        $response->assertViewHas('zone');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $zone = Zone::factory()->create();

        $response = $this->get(route('zones.edit', $zone));

        $response->assertOk();
        $response->assertViewIs('zone.edit');
        $response->assertViewHas('zone');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ZoneController::class,
            'update',
            \App\Http\Requests\ZoneUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $zone = Zone::factory()->create();
        $nom = fake()->word();
        $niveau = fake()->numberBetween(-10000, 10000);

        $response = $this->put(route('zones.update', $zone), [
            'nom' => $nom,
            'niveau' => $niveau,
        ]);

        $zone->refresh();

        $response->assertRedirect(route('zones.index'));
        $response->assertSessionHas('zone.id', $zone->id);

        $this->assertEquals($nom, $zone->nom);
        $this->assertEquals($niveau, $zone->niveau);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $zone = Zone::factory()->create();

        $response = $this->delete(route('zones.destroy', $zone));

        $response->assertRedirect(route('zones.index'));

        $this->assertModelMissing($zone);
    }
}
