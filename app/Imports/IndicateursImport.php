<?php

namespace App\Imports;

use App\Models\Indicateur;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IndicateursImport implements ToCollection, WithHeadingRow
{
    protected array $failedRows = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Vérification du doublon
            $exists = Indicateur::where('intitule', $row['intitule'])
                        ->orWhere('code', $row['code'])
                        ->exists();

            if ($exists) {

                $this->failedRows[] = [
                    'intitule' => $row['intitule'] ?? 'N/A',
                    'code'     => $row['code'] ?? 'N/A',
                    'raison'   => 'Doublon',
                ];

                continue;
            }

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

                $this->failedRows[] = [
                    'intitule' => $row['intitule'] ?? 'N/A',
                    'code'     => $row['code'] ?? 'N/A',
                    'raison'   => $e->getMessage(),
                ];
            }
        }
    }

    public function getFailedRows(): array
    {
        return $this->failedRows;
    }
}