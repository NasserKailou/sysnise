<?php

namespace App\Exports;

use App\Models\NatureDonnee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class NatureDonneesSheetExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
		return NatureDonnee::select('intitule', 'id')->get();
    }
	
	public function headings(): array
    {
        return [
            'Intitulé',
			'Id'
            
        ];
    }

    public function title(): string
    {
        return 'NatureDonnees'; 
    }
}