<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DataSheetExport implements FromArray, WithHeadings, WithTitle
{
	public function array(): array
    {
        $rows = [];			
		$formula = '=CONCAT(' .
			'RECHERCHEV(B2,Indicateurs!$A:$B,2,0),"-",' .
			'RECHERCHEV(C2,Zones!$A:$B,2,0),"-",' .
			'CONCAT(IF(K2<>"",VLOOKUP(K2,Desagregations!$A:$B,2,0),""),IF(L2<>"","_",""),IF(L2<>"",VLOOKUP(L2,Desagregations!$A:$B,2,0),""),IF(M2<>"","_",""),IF(M2<>"",VLOOKUP(M2,Desagregations!$A:$B,2,0),""),IF(N2<>"","_",""),IF(N2<>"",VLOOKUP(N2,Desagregations!$A:$B,2,0),""),IF(O2<>"","_",""),IF(O2<>"",VLOOKUP(O2,Desagregations!$A:$B,2,0),""),IF(P2<>"","_",""),IF(P2<>"",VLOOKUP(P2,Desagregations!$A:$B,2,0),"")),"-",'.
			'RECHERCHEV(D2,Unites!$A:$B,2,0),"-",' .
			'RECHERCHEV(E2,Sources!$A:$B,2,0),"-",' .
			'RECHERCHEV(F2,CommentaireValeurIndicateurs!$A:$B,2,0),"-",' .
			'RECHERCHEV(G2,NatureDonnees!$A:$B,2,0),"-",' .
			'RECHERCHEV(H2,Periodes!$A:$B,2,0)' .
		')';

		// Ligne vide avec la formule en colonne A
		$rows[] = [
			$formula, // A: Code
			'',       // B: Indicateur
			'',       // C: Zone     
			'',       // D: Unité
			'',       // E: Source
			'',       // F: Commentaire
			'',       // G: Nature Donnée
			'',       // H: Période
			'',       // I: Valeur
			'',		//colonne de séparation 
			'', 	// K: Désagrégation
		];

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Code',
            'Indicateur',
			'Zone',
			'Unite',
			'Source',
			'CommentaireValeur',
			'NatureDonnee',
			'Periode',
			'valeur',
			'',
			'Début Désagregation',
        ];
    }

    public function title(): string
    {
        return 'Data';
    }
}