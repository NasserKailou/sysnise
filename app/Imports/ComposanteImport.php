<?php

namespace App\Imports;
use App\Models\Composante;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ComposanteImport implements ToCollection, WithHeadingRow
{
    protected int $projetId;

    /**
     * Tableau de correspondance entre
     * l'id du fichier Excel et l'id réel en base
     */
    protected array $idMap = [];

    public function __construct(int $projetId)
    {
        $this->projetId = $projetId;
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
			try{
            /**
             * Étape 1 : insertion des éléments racines
             * (composante_id vide dans le fichier Excel)
             */
            foreach ($rows as $row) {
                if (empty($row['composante_id'])) {
                    
					$composante = Composante::create([
                        'intitule' => $row['intitule'],
						'projet_id' => $this->projetId,
                        'composante_id' => null,
                    ]);
					

                    // mémorisation de la correspondance
                    $this->idMap[$row['id']] = $composante->id;

                    
                }
            }

            /**
             * Étape 2 : insertion des enfants
             */
            foreach ($rows as $row) {
                if (!empty($row['composante_id'])) {
                    $parentExcelId = $row['composante_id'];

                    if (!isset($this->idMap[$parentExcelId])) {
                        throw new \Exception("Parent non trouvé pour la ligne : {$row['intitule']}");
                    }

                    $composante = Composante::create([
                        'intitule' => $row['intitule'],
						'projet_id' => $this->projetId,
                        'composante_id' => $this->idMap[$parentExcelId],
                    ]);

                    $this->idMap[$row['id']] = $composante->id;
                }
            }
			}catch(Exception $e){
						print_r($e);die();
					}
        });
		
    }
}