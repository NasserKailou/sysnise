<?php

namespace App\Exports;

use App\Models\SourceIndicateur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SourcesSheetExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
		return SourceIndicateur::select('intitule', 'id')->get();
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
        return 'Sources'; 
    }
}