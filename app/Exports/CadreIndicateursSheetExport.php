<?php

namespace App\Exports;

use App\Models\Indicateur;
use App\Models\CadreDeveloppement;
use App\Models\OrientationCadreDeveloppement;
use App\Models\CadreLogique;
use App\Models\CadreMesureResultat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Collection;

class CadreIndicateursSheetExport implements FromCollection, WithHeadings, WithTitle
{
    protected $cadreDeveloppementId;

    public function __construct($cadreDeveloppementId)
    {
        $this->cadreDeveloppementId = $cadreDeveloppementId;
    }

    public function collection()
    {
        // Récupérer tous les cadres logiques liés au cadre de développement
        // via la table orientation_cadre_developpements
        $cadreLogiquesIds = OrientationCadreDeveloppement::where('cadre_developpement_id', $this->cadreDeveloppementId)
            ->pluck('cadre_logique_id')
            ->toArray();

        // Si aucun cadre logique trouvé, retourner une collection vide
        if (empty($cadreLogiquesIds)) {
            return collect([]);
        }

        // Fonction récursive pour obtenir tous les enfants d'un cadre logique
        $getAllChildren = function($cadreLogiquesIds) use (&$getAllChildren) {
            $allIds = $cadreLogiquesIds;
            
            $children = CadreLogique::whereIn('cadre_logique_id', $cadreLogiquesIds)
                ->pluck('id')
                ->toArray();
            
            if (!empty($children)) {
                $allIds = array_merge($allIds, $getAllChildren($children));
            }
            
            return $allIds;
        };

        // Obtenir tous les cadres logiques (parents + enfants)
        $allCadreLogiquesIds = $getAllChildren($cadreLogiquesIds);
        $allCadreLogiquesIds = array_unique($allCadreLogiquesIds);

        // Récupérer tous les indicateurs liés à ces cadres logiques
        // via la table cadre_mesure_resultats
        $indicateurIds = CadreMesureResultat::whereIn('cadre_logique_id', $allCadreLogiquesIds)
            ->pluck('indicateur_id')
            ->unique()
            ->toArray();

        // Si aucun indicateur trouvé, retourner une collection vide
        if (empty($indicateurIds)) {
            return collect([]);
        }

        // Retourner les indicateurs avec seulement les colonnes nécessaires
        return Indicateur::whereIn('id', $indicateurIds)
            ->select('intitule', 'id')
            ->get();
    }
    
    public function headings(): array
    {
        return [
            'Intitulé',
            'Id'
        ];
    }

    public function title(): string
    {
        return 'Indicateurs'; 
    }
}
