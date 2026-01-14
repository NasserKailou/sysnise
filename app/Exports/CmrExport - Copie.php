<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CmrExport implements FromCollection, WithHeadings
{
    protected $cadre_id;

    public function __construct($cadre_id)
    {
        $this->cadre_id = $cadre_id;
    }

    public function collection()
    {
        return DB::table('view_cmr')
            ->where('cadre_developpement_id', $this->cadre_id)
            ->select(
                'cadre_id',
                'cadre_intitule',
                'parent_id',
                'niveau',
                'indicateur_intitule',
                'nature_donnee_intitule',
                'zone_intitule',
				'desagregations',
				'source_intitule',
				'unite_intitule',
				'periode_intitule',
				'valeur'
            )
			->orderBy('parent_id')
			->orderBy('cadre_id') 
            ->get();
    }

    public function headings(): array
    {
        return [
            'cadre_id',
			'cadre_intitule',
			'parent_id',
			'niveau',
			'indicateur_intitule',
			'nature_donnee_intitule',
			'zone_intitule',
			'desagregations',
			'source_intitule',
			'unite_intitule',
			'periode_intitule',
			'valeur'
        ];
    }
}
