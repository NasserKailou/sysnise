<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\IndicateurApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\IndicateurApiController
 */
final class IndicateurApiControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $indicateurApis = IndicateurApi::factory()->count(3)->create();

        $response = $this->get(route('indicateur-apis.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IndicateurApiController::class,
            'store',
            \App\Http\Requests\IndicateurApiStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $response = $this->post(route('indicateur-apis.store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(indicateurApis, [ /* ... */ ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $indicateurApi = IndicateurApi::factory()->create();

        $response = $this->get(route('indicateur-apis.show', $indicateurApi));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IndicateurApiController::class,
            'update',
            \App\Http\Requests\IndicateurApiUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $indicateurApi = IndicateurApi::factory()->create();

        $response = $this->put(route('indicateur-apis.update', $indicateurApi));

        $indicateurApi->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $indicateurApi = IndicateurApi::factory()->create();

        $response = $this->delete(route('indicateur-apis.destroy', $indicateurApi));

        $response->assertNoContent();

        $this->assertModelMissing($indicateurApi);
    }
}
