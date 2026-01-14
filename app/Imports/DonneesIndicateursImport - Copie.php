<?php

namespace App\Imports;

use App\Models\DonneeIndicateur;
use App\Models\DonneeIndicateurDesagregation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DonneesIndicateursImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
		$data = explode("-", $row['code']);
		// Sécurité : éviter erreurs d’index
        if (empty($row['code']) || empty($row['valeur'])) {
			return null;
		}
		if (count($data) < 8) {
            return null; // ou logger une erreur
        }
        $donneeIndicateur = new DonneeIndicateur([
            'indicateur_id' => $data[0]?? null,
			'zone_id' => $data[1]?? null,
			'unite_indicateur_id' => $data[3]?? null,
			'source_indicateur_id' => $data[4]?? null,
			'commentaire_valeur_indicateur_id' => $data[5]?? null,
			'nature_donnee_id' => $data[6]?? null,
			'periode_id' => $data[7]?? null,
			'valeur' => $row['valeur']
        ]);
		
		$donneeIndicateur->save();
		
		$desagregations = explode("_", $data[2] ?? '');
		foreach ($desagregations as $desagregation) {
			// création de la ligne associée
			DonneeIndicateurDesagregation::create([
				'donnee_indicateur_id' => $donneeIndicateur->id,
				'desagregation_id' => $desagregation,
			]);
            
        }
		return $donneeIndicateur;
	}
}
