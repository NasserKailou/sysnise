<?php

namespace App\Imports;

use App\Models\Indicateur;
use Illuminate\Support\Collection;
//use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IndicateursImport implements ToCollection, WithHeadingRow
{
    protected array $failedRows = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                Indicateur::create([
                    'intitule' => $row['intitule'],
					'code' => $row['code'] ?? null,
					'definition' => $row['definition'] ?? null,
					'donnees_requises' => $row['donnees_requises'] ?? null,
					'methode_calcul' => $row['methode_calcul'] ?? null,
					'methode_collecte' => $row['methode_collecte'] ?? null,
					'source' => $row['source'] ?? null,
					'commentaire_limite' => $row['commentaire_limite'] ?? null,
					'niveau_desagregation' => $row['niveau_desagregation'] ?? null,
					'periodicite' => $row['periodicite'] ?? null,
					'unite' => $row['unite'] ?? null,
					'echelle' => '',
					'lien_avec_cadre_developpement' => $row['lien_avec_cadre_developpement'] ?? null
                ]);
            } catch (\Throwable $e) {
				$message = strtolower($e->getMessage());
                // On mémorise les indicateurs non insérés
                $this->failedRows[] = [
                    'intitule' => $row['intitule'] ?? 'N/A',
					'code'    => $row['code'] ?? 'N/A',
                    'raison'   => (
						str_contains($message, 'duplicate') ||
						str_contains($message, 'unique') ||
						str_contains($message, 'dupliquée') ||
						str_contains($message, 'doublon')
					)
						? 'Doublon'
						: 'Erreur technique',
					
                ];

                // On continue l'import
                continue;
            }
        }
    }

    public function getFailedRows(): array
    {
        return $this->failedRows;
    }
}