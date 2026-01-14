<?php
namespace App\Imports;

use App\Imports\DonneesIndicateursImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DonneesImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            // On indique qu'on ne veut importer que la feuille "Data"
            'Data' => new DonneesIndicateursImport()
        ];
    }
}
