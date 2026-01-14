<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new IndicateursSheetExport(),
            new DesagregationsSheetExport(),
            new SourcesSheetExport(),
			new UnitesSheetExport(),
            new ZonesSheetExport(),
            new PeriodesSheetExport(),
			new CommentaireValeursSheetExport(),
            new NatureDonneesSheetExport(),
			new DataSheetExport(),
        ];
    }
}
