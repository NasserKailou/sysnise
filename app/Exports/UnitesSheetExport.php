<?php

namespace App\Exports;

use App\Models\UniteIndicateur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UnitesSheetExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
		return UniteIndicateur::select('intitule', 'id')->get();
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
        return 'Unites'; 
    }
}