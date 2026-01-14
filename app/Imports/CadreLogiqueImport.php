<?php

namespace App\Imports;
use App\Models\CadreLogique;
use App\Models\OrientationCadreDeveloppement;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class CadreLogiqueImport implements ToCollection, WithHeadingRow
{
    protected int $cadreDeveloppementId;

    /**
     * Tableau de correspondance entre
     * l'id du fichier Excel et l'id réel en base
     */
    protected array $idMap = [];

    public function __construct(int $cadreDeveloppementId)
    {
        $this->cadreDeveloppementId = $cadreDeveloppementId;
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {

            /**
             * Étape 1 : insertion des éléments racines
             * (cadre_logique_id vide dans le fichier Excel)
             */
            foreach ($rows as $row) {
                if (empty($row['cadre_logique_id'])) {
                    $cadre = CadreLogique::create([
                        'intitule' => $row['intitule'],
                        'cadre_logique_id' => null,
                    ]);

                    // mémorisation de la correspondance
                    $this->idMap[$row['id']] = $cadre->id;

                    // insertion dans orientation_cadre_developpement
                    OrientationCadreDeveloppement::create([
                        'cadre_developpement_id' => $this->cadreDeveloppementId,
                        'cadre_logique_id'       => $cadre->id,
                        'intitule'               => $row['intitule'],
                    ]);
                }
            }

            /**
             * Étape 2 : insertion des enfants
             */
            foreach ($rows as $row) {
                if (!empty($row['cadre_logique_id'])) {
                    $parentExcelId = $row['cadre_logique_id'];

                    if (!isset($this->idMap[$parentExcelId])) {
                        throw new \Exception("Parent non trouvé pour la ligne : {$row['intitule']}");
                    }

                    $cadre = CadreLogique::create([
                        'intitule' => $row['intitule'],
                        'cadre_logique_id' => $this->idMap[$parentExcelId],
                    ]);

                    $this->idMap[$row['id']] = $cadre->id;
                }
            }
        });
    }
}