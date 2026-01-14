<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ExcelController
 */
final class ExcelControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function import_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ExcelController::class,
            'import',
            \App\Http\Requests\ExcelImportRequest::class
        );
    }

    #[Test]
    public function import_saves(): void
    {
        $response = $this->get(route('excels.import'));

        $this->assertDatabaseHas(files, [ /* ... */ ]);
    }


    #[Test]
    public function export_responds_with(): void
    {
        $response = $this->get(route('excels.export'));

        $response->assertOk();
        $response->assertJson($export);
    }
}
