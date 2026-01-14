<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Indicateur(api);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Indicateur(api)Controller
 */
final class Indicateur(api)ControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $indicateur(api) = Indicateur(api)::factory()->count(3)->create();

        $response = $this->get(route('indicateur(api).index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Indicateur(api)Controller::class,
            'store',
            \App\Http\Requests\Indicateur(api)StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $response = $this->post(route('indicateur(api).store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(indicateur(api), [ /* ... */ ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $indicateur(api) = Indicateur(api)::factory()->create();

        $response = $this->get(route('indicateur(api).show', $indicateur(api)));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Indicateur(api)Controller::class,
            'update',
            \App\Http\Requests\Indicateur(api)UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $indicateur(api) = Indicateur(api)::factory()->create();

        $response = $this->put(route('indicateur(api).update', $indicateur(api)));

        $indicateur(api)->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $indicateur(api) = Indicateur(api)::factory()->create();

        $response = $this->delete(route('indicateur(api).destroy', $indicateur(api)));

        $response->assertNoContent();

        $this->assertModelMissing($indicateur(api));
    }
}
