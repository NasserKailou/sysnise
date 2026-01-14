<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class DataSheetExport implements FromArray, WithHeadings, WithTitle, WithEvents
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Définir le nombre de lignes pour les listes déroulantes (par exemple 1000 lignes)
                $maxRow = 1000;
                
                // Colonne B: Indicateur - référence à la feuille Indicateurs (colonne A)
                $validation = $sheet->getCell('B2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Erreur de saisie');
                $validation->setError('La valeur doit être choisie dans la liste.');
                $validation->setPromptTitle('Indicateur');
                $validation->setPrompt('Sélectionnez un indicateur');
                $validation->setFormula1('Indicateurs!$A$2:$A$' . $maxRow);
                
                // Appliquer la validation à toute la colonne B (de B2 à B1000)
                for ($row = 2; $row <= $maxRow; $row++) {
                    $sheet->getCell('B' . $row)->setDataValidation(clone $validation);
                }
                
                // Colonne C: Zone - référence à la feuille Zones (colonne A)
                $validation = $sheet->getCell('C2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Erreur de saisie');
                $validation->setError('La valeur doit être choisie dans la liste.');
                $validation->setPromptTitle('Zone');
                $validation->setPrompt('Sélectionnez une zone');
                $validation->setFormula1('Zones!$A$2:$A$' . $maxRow);
                
                for ($row = 2; $row <= $maxRow; $row++) {
                    $sheet->getCell('C' . $row)->setDataValidation(clone $validation);
                }
                
                // Colonne D: Unite - référence à la feuille Unites (colonne A)
                $validation = $sheet->getCell('D2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Erreur de saisie');
                $validation->setError('La valeur doit être choisie dans la liste.');
                $validation->setPromptTitle('Unité');
                $validation->setPrompt('Sélectionnez une unité');
                $validation->setFormula1('Unites!$A$2:$A$' . $maxRow);
                
                for ($row = 2; $row <= $maxRow; $row++) {
                    $sheet->getCell('D' . $row)->setDataValidation(clone $validation);
                }
                
                // Colonne E: Source - référence à la feuille Sources (colonne A)
                $validation = $sheet->getCell('E2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Erreur de saisie');
                $validation->setError('La valeur doit être choisie dans la liste.');
                $validation->setPromptTitle('Source');
                $validation->setPrompt('Sélectionnez une source');
                $validation->setFormula1('Sources!$A$2:$A$' . $maxRow);
                
                for ($row = 2; $row <= $maxRow; $row++) {
                    $sheet->getCell('E' . $row)->setDataValidation(clone $validation);
                }
                
                // Colonne F: CommentaireValeur - référence à la feuille CommentaireValeurIndicateurs (colonne A)
                $validation = $sheet->getCell('F2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Erreur de saisie');
                $validation->setError('La valeur doit être choisie dans la liste.');
                $validation->setPromptTitle('Commentaire Valeur');
                $validation->setPrompt('Sélectionnez un commentaire');
                $validation->setFormula1('CommentaireValeurIndicateurs!$A$2:$A$' . $maxRow);
                
                for ($row = 2; $row <= $maxRow; $row++) {
                    $sheet->getCell('F' . $row)->setDataValidation(clone $validation);
                }
                
                // Colonne G: NatureDonnee - référence à la feuille NatureDonnees (colonne A)
                $validation = $sheet->getCell('G2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Erreur de saisie');
                $validation->setError('La valeur doit être choisie dans la liste.');
                $validation->setPromptTitle('Nature Donnée');
                $validation->setPrompt('Sélectionnez une nature de donnée');
                $validation->setFormula1('NatureDonnees!$A$2:$A$' . $maxRow);
                
                for ($row = 2; $row <= $maxRow; $row++) {
                    $sheet->getCell('G' . $row)->setDataValidation(clone $validation);
                }
                
                // Colonne H: Periode - référence à la feuille Periodes (colonne A)
                $validation = $sheet->getCell('H2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Erreur de saisie');
                $validation->setError('La valeur doit être choisie dans la liste.');
                $validation->setPromptTitle('Période');
                $validation->setPrompt('Sélectionnez une période');
                $validation->setFormula1('Periodes!$A$2:$A$' . $maxRow);
                
                for ($row = 2; $row <= $maxRow; $row++) {
                    $sheet->getCell('H' . $row)->setDataValidation(clone $validation);
                }
                
                // Colonnes K à P: Désagregations - référence à la feuille Desagregations (colonne A)
                // Ces colonnes permettent de saisir plusieurs désagrégations
                $desagregationColumns = ['K', 'L', 'M', 'N', 'O', 'P'];
                foreach ($desagregationColumns as $col) {
                    $validation = $sheet->getCell($col . '2')->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(true); // Désagrégations optionnelles
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Erreur de saisie');
                    $validation->setError('La valeur doit être choisie dans la liste.');
                    $validation->setPromptTitle('Désagrégation');
                    $validation->setPrompt('Sélectionnez une désagrégation (optionnel)');
                    $validation->setFormula1('Desagregations!$A$2:$A$' . $maxRow);
                    
                    for ($row = 2; $row <= $maxRow; $row++) {
                        $sheet->getCell($col . $row)->setDataValidation(clone $validation);
                    }
                }
            },
        ];
    }
}