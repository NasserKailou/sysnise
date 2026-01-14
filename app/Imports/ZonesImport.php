<?php

namespace App\Imports;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ZonesImport implements ToCollection, WithHeadingRow
{
    
    /**
     * Tableau de correspondance entre
     * l'id du fichier Excel et l'id réel en base
     */
    protected array $idMap = [];

    public function __construct()
    {
        
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {

            /**
             * Étape 1 : insertion des éléments racines
             * (cadre_logique_id vide dans le fichier Excel)
             */
            foreach ($rows as $row) {
                if (empty($row['zone_id'])) {
                    $zone = Zone::create([
                        'intitule' => $row['intitule'],
						'code' => $row['code'],
						'latitude' => $row['latitude'],
						'longitude' => $row['longitude'],
						'niveau' => $row['niveau'],
                        'zone_id' => null,
                    ]);

                    // mémorisation de la correspondance
                    $this->idMap[$row['id']] = $zone->id;

                }
            }

            /**
             * Étape 2 : insertion des enfants
             */
            foreach ($rows as $row) {
                if (!empty($row['zone_id'])) {
                    $parentExcelId = $row['zone_id'];

                    if (!isset($this->idMap[$parentExcelId])) {
                        throw new \Exception("Parent non trouvé pour la ligne : {$row['intitule']}");
                    }

                    $zone = Zone::create([
                        'intitule' => $row['intitule'],
						'code' => $row['code'],
						'latitude' => $row['latitude'],
						'longitude' => $row['longitude'],
						'niveau' => $row['niveau'],
                        'zone_id' => $this->idMap[$parentExcelId],
                    ]);

                    $this->idMap[$row['id']] = $zone->id;
                }
            }
        });
    }
}