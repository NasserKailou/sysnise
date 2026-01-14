<?php

namespace App\Imports;

use App\Models\DonneeIndicateur;
use App\Models\DonneeIndicateurDesagregation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DonneesIndicateursImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Vérification minimale
        if (empty($row['code']) || !isset($row['valeur'])) {
            return null;
        }

        $data = explode("-", $row['code']);

        if (count($data) < 8) {
            return null; // Code mal formé
        }

        // Extraire les clés et valeurs
        $indicateur_id = $data[0] ?? null;
        $zone_id = $data[1] ?? null;
        $desagregations = explode("_", $data[2] ?? '');
        $unite_indicateur_id = $data[3] ?? null;
        $source_indicateur_id = $data[4] ?? null;
        $commentaire_valeur_indicateur_id = $data[5] ?? null;
        $nature_donnee_id = $data[6] ?? null;
        $periode_id = $data[7] ?? null;

        // Transaction pour cohérence
        return DB::transaction(function () use (
            $indicateur_id,
            $zone_id,
            $unite_indicateur_id,
            $source_indicateur_id,
            $commentaire_valeur_indicateur_id,
            $nature_donnee_id,
            $periode_id,
            $desagregations,
            $row
        ) {
            // Met à jour ou crée la donnée
            $donneeIndicateur = DonneeIndicateur::updateOrCreate(
                [
                    'indicateur_id' => $indicateur_id,
                    'zone_id' => $zone_id,
                    'unite_indicateur_id' => $unite_indicateur_id,
                    'source_indicateur_id' => $source_indicateur_id,
                    'commentaire_valeur_indicateur_id' => $commentaire_valeur_indicateur_id,
                    'nature_donnee_id' => $nature_donnee_id,
                    'periode_id' => $periode_id,
                ],
                [
                    'valeur' => $row['valeur']
                ]
            );
			
			// Synchronisation des désagrégations via Eloquent
			//$desagregations = array_filter(explode('_', $data[2] ?? ''));
			if (!empty($desagregations)) {
				$donneeIndicateur->desagregations()->sync($desagregations);
			}

            return $donneeIndicateur;
        });
    }
}
