<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CadreDataTemplateExport implements WithMultipleSheets
{
    protected $cadreDeveloppementId;

    public function __construct($cadreDeveloppementId)
    {
        $this->cadreDeveloppementId = $cadreDeveloppementId;
    }

    public function sheets(): array
    {
        return [
            new CadreIndicateursSheetExport($this->cadreDeveloppementId),
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
