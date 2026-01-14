<?php

namespace App\Exports;

use App\Models\CommentaireValeurIndicateur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CommentaireValeursSheetExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
		return CommentaireValeurIndicateur::select('intitule', 'id')->get();
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
        return 'CommentaireValeurIndicateurs'; 
    }
}