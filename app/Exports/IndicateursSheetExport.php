<?php

namespace App\Exports;

use App\Models\Indicateur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class IndicateursSheetExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        //return Indicateur::all();
		/*return Indicateur::select('id', 'intitule')
        ->where('is_valide', 1)
        ->get();*/
		return Indicateur::select('intitule', 'id')->get();
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
        return 'Indicateurs'; 
    }
}