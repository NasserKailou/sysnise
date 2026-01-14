<?php

namespace App\Imports;

use App\Models\Indicateur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IndicateursImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Indicateur([
            'intitule' => $row['intitule'],
            'code' => $row['code'],
			'definition' => $row['definition'],
			'donnees_requises' => $row['donnees_requises'],
			'methode_calcul' => $row['methode_calcul'],
			'methode_collecte' => $row['methode_collecte'],
			'source' => $row['source'],
			'commentaire_limite' => $row['commentaire_limite'],
			'niveau_desagregation' => $row['niveau_desagregation'],
			'periodicite' => $row['periodicite'],
			'unite' => $row['unite'],
			'echelle' => '',
			'lien_avec_cadre_developpement' => $row['lien_avec_cadre_developpement']
        ]);
    }
}
