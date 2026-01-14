<?php

namespace App\Exports;

use App\Models\Zone;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ZonesSheetExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
		return Zone::select('intitule', 'id', 'niveau')->get();
    }
	
	public function headings(): array
    {
        return [
            'Intitulé',
			'Id', 
			'Niveau'
        ];
    }

    public function title(): string
    {
        return 'Zones'; 
    }
}