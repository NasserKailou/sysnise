<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Projet;
use App\Models\CadreDeveloppement;
use App\Models\Secteur;
use App\Models\Zone;
use App\Models\Bailleur;
use App\Models\StatutProjet;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord principal
     */
    public function index()
    {
        $breadcrumb = 'Tableau de Bord > Vue d\'ensemble';
        
        // Statistiques globales
        $stats = $this->getGlobalStats();
        
        // Données pour les graphiques
        $chartsData = $this->getChartsData();
        
        // Données du tableau des projets avec financements
        $projetsFinancement = $this->getProjetsFinancement();
        
        return view('dashboard.index', compact('breadcrumb', 'stats', 'chartsData', 'projetsFinancement'));
    }
    
    /**
     * Obtenir les statistiques globales
     */
    private function getGlobalStats()
    {
        return [
            'total_projets' => Projet::whereNull('deleted_on')->count(),
            'total_cadres' => CadreDeveloppement::where('type_cadre_developpement_id', 1)
                ->whereNull('deleted_on')
                ->count(),
            'total_financement' => DB::table('projet_plan_financements')
                ->whereNull('deleted_on')
                ->sum('montant'),
            'total_budget_prevu' => DB::table('projet_budget_annuels')
                ->where('statut_budget_id', 1)
                ->whereNull('deleted_on')
                ->sum('montant'),
            'total_budget_depense' => DB::table('projet_budget_annuels')
                ->where('statut_budget_id', 2)
                ->whereNull('deleted_on')
                ->sum('montant'),
            'projets_actifs' => Projet::join('statut_projets', 'projets.statut_projet_id', '=', 'statut_projets.id')
                ->where(function($q) {
                    $q->where('statut_projets.intitule', 'like', '%Exécution%')
                      ->orWhere('statut_projets.intitule', 'like', '%exécution%')
                      ->orWhere('statut_projets.intitule', 'like', '%En cours%')
                      ->orWhere('statut_projets.intitule', 'like', '%en cours%');
                })
                ->whereNull('projets.deleted_on')
                ->count(),
        ];
    }
    
    /**
     * Obtenir les données pour les graphiques
     */
    private function getChartsData()
    {
        return [
            'financement_par_secteur' => $this->getFinancementParSecteur(),
            'financement_par_region' => $this->getFinancementParRegion(),
            'projets_par_statut' => $this->getProjetsParStatut(),
            'financement_par_bailleur' => $this->getFinancementParBailleur(),
            'evolution_budgets' => $this->getEvolutionBudgets(),
            'repartition_sexe' => $this->getRepartitionSexe(),
            'tranches_age' => $this->getTranchesAge(),
        ];
    }
    
    /**
     * Financement par secteur
     */
    private function getFinancementParSecteur()
    {
        return DB::table('projet_plan_financements as ppf')
            ->join('projets as p', 'ppf.projet_id', '=', 'p.id')
            ->join('projet_secteur as ps', 'p.id', '=', 'ps.projet_id')
            ->join('secteurs as s', 'ps.secteur_id', '=', 's.id')
            ->select('s.intitule as secteur', DB::raw('SUM(ppf.montant) as montant'))
            ->whereNull('ppf.deleted_on')
            ->whereNull('p.deleted_on')
            ->groupBy('s.id', 's.intitule')
            ->orderBy('montant', 'desc')
            ->get();
    }
    
    /**
     * Financement par région
     */
    private function getFinancementParRegion()
    {
        return DB::table('projet_plan_financements as ppf')
            ->join('projets as p', 'ppf.projet_id', '=', 'p.id')
            ->join('projet_zone as pz', 'p.id', '=', 'pz.projet_id')
            ->join('zones as z', 'pz.zone_id', '=', 'z.id')
            ->select('z.intitule as region', DB::raw('SUM(ppf.montant) as montant'))
            ->where('z.niveau', 2)
            //->whereNull('ppf.deleted_on')
            ->whereNull('p.deleted_on')
            //->whereNull('pz.deleted_on')
            ->groupBy('z.id', 'z.intitule')
            ->orderBy('montant', 'desc')
            ->get();
    }
    
    /**
     * Projets par statut
     */
    private function getProjetsParStatut()
    {
        return DB::table('projets as p')
            ->join('statut_projets as sp', 'p.statut_projet_id', '=', 'sp.id')
            ->select('sp.intitule as statut', DB::raw('COUNT(*) as nombre'))
            ->whereNull('p.deleted_on')
            ->groupBy('sp.id', 'sp.intitule')
            ->get();
    }
    
    /**
     * Financement par bailleur
     */
    private function getFinancementParBailleur()
    {
        return DB::table('projet_plan_financements as ppf')
            ->join('bailleurs as b', 'ppf.bailleur_id', '=', 'b.id')
            ->select('b.intitule as bailleur', DB::raw('SUM(ppf.montant) as montant'))
            ->whereNull('ppf.deleted_on')
            ->groupBy('b.id', 'b.intitule')
            ->orderBy('montant', 'desc')
            ->limit(10)
            ->get();
    }
    
    /**
     * Evolution des budgets par année
     */
    private function getEvolutionBudgets()
    {
        return DB::table('projet_budget_annuels as pba')
            ->join('statut_budgets as sb', 'pba.statut_budget_id', '=', 'sb.id')
            ->select(
                'pba.annee',
                'sb.intitule as type',
                DB::raw('SUM(pba.montant) as montant')
            )
            ->whereNull('pba.deleted_on')
            ->groupBy('pba.annee', 'sb.id', 'sb.intitule')
            ->orderBy('pba.annee')
            ->get();
    }
    
    /**
     * Répartition par sexe (candidats recrutement)
     */
    private function getRepartitionSexe()
    {
        // Simulation pour l'exemple - adapter selon votre structure
        return collect([
            ['sexe' => 'Homme', 'nombre' => 5739],
            ['sexe' => 'Femme', 'nombre' => 1010],
        ]);
    }
    
    /**
     * Candidats par tranche d'âge
     */
    private function getTranchesAge()
    {
        // Simulation pour l'exemple - adapter selon votre structure
        return collect([
            ['tranche' => 'Moins de 20 ans', 'nombre' => 61],
            ['tranche' => '20-24 ans', 'nombre' => 913],
            ['tranche' => '25-29 ans', 'nombre' => 2691],
            ['tranche' => '30-34 ans', 'nombre' => 2154],
            ['tranche' => '35-39 ans', 'nombre' => 635],
            ['tranche' => '40 ans et +', 'nombre' => 295],
        ]);
    }
    
    /**
     * Obtenir les données des projets avec leurs financements
     */
    private function getProjetsFinancement()
    {
        return DB::table('projets as p')
            ->leftJoin('statut_projets as sp', 'p.statut_projet_id', '=', 'sp.id')
            ->leftJoin('institution_tutelles as it', 'p.institution_tutelle_id', '=', 'it.id')
            ->leftJoin('projet_secteur as ps', 'p.id', '=', 'ps.projet_id')
            ->leftJoin('secteurs as s', 'ps.secteur_id', '=', 's.id')
            ->select(
                'p.id',
                'p.sigle',
                'p.intitule',
                'sp.intitule as statut',
                'it.intitule as institution_tutelle',
                DB::raw('STRING_AGG(DISTINCT s.intitule, \', \') as secteurs'),
                DB::raw('COALESCE(p.cout, 0) as financement_prevu'),
                DB::raw('COALESCE((
                    SELECT SUM(pba1.montant) 
                    FROM projet_budget_annuels pba1 
                    JOIN projet_plan_financements ppf1 ON pba1.plan_financement_id = ppf1.id
                    WHERE ppf1.projet_id = p.id 
                    AND pba1.statut_budget_id = 3
                    AND pba1.deleted_on IS NULL 
                    AND ppf1.deleted_on IS NULL
                ), 0) as budget_budgetise'),
                DB::raw('COALESCE((
                    SELECT SUM(pba2.montant) 
                    FROM projet_budget_annuels pba2 
                    JOIN projet_plan_financements ppf2 ON pba2.plan_financement_id = ppf2.id
                    WHERE ppf2.projet_id = p.id 
                    AND pba2.statut_budget_id = 2
                    AND pba2.deleted_on IS NULL 
                    AND ppf2.deleted_on IS NULL
                ), 0) as budget_depense'),
                DB::raw('CASE 
                    WHEN COALESCE((
                        SELECT SUM(pba3.montant) 
                        FROM projet_budget_annuels pba3 
                        JOIN projet_plan_financements ppf3 ON pba3.plan_financement_id = ppf3.id
                        WHERE ppf3.projet_id = p.id 
                        AND pba3.statut_budget_id = 3
                        AND pba3.deleted_on IS NULL 
                        AND ppf3.deleted_on IS NULL
                    ), 0) = 0 THEN 0
                    ELSE ROUND((
                        COALESCE((
                            SELECT SUM(pba4.montant) 
                            FROM projet_budget_annuels pba4 
                            JOIN projet_plan_financements ppf4 ON pba4.plan_financement_id = ppf4.id
                            WHERE ppf4.projet_id = p.id 
                            AND pba4.statut_budget_id = 2
                            AND pba4.deleted_on IS NULL 
                            AND ppf4.deleted_on IS NULL
                        ), 0) * 100.0 / NULLIF((
                            SELECT SUM(pba5.montant) 
                            FROM projet_budget_annuels pba5 
                            JOIN projet_plan_financements ppf5 ON pba5.plan_financement_id = ppf5.id
                            WHERE ppf5.projet_id = p.id 
                            AND pba5.statut_budget_id = 3
                            AND pba5.deleted_on IS NULL 
                            AND ppf5.deleted_on IS NULL
                        ), 0)
                    ), 2)
                END as taux_consommation')
            )
            ->whereNull('p.deleted_on')
            ->groupBy('p.id', 'p.sigle', 'p.intitule', 'p.cout', 'sp.intitule', 'it.intitule')
            ->orderBy('p.intitule')
            ->get();
    }
    
    /**
     * Exporter le fichier plat des projets
     */
    public function exportProjetsFichierPlat()
    {
        $sql = $this->getSQLProjetsFichierPlat();
        
        $projets = DB::select($sql);
        
        // Créer le fichier CSV
        $filename = 'projets_fichier_plat_' . date('Y-m-d_His') . '.csv';
        $filepath = storage_path('app/public/' . $filename);
        
        $file = fopen($filepath, 'w');
        
        // En-têtes
        if (count($projets) > 0) {
            fputcsv($file, array_keys((array)$projets[0]));
        }
        
        // Données
        foreach ($projets as $projet) {
            fputcsv($file, (array)$projet);
        }
        
        fclose($file);
        
        return response()->download($filepath)->deleteFileAfterSend(true);
    }
    
    /**
     * Requête SQL pour fichier plat des projets
     */
    private function getSQLProjetsFichierPlat()
    {
        return "
            SELECT 
                p.id as projet_id,
                p.sigle as projet_sigle,
                p.intitule as projet_intitule,
                p.annee_demarrage,
                p.date_debut_prevue,
                p.date_fin_prevue,
                p.date_debut_effective,
                p.date_fin_effective,
                p.date_approbation,
                p.date_signature,
                p.date_mise_en_vigueur,
                p.duree,
                p.cout as cout_total,
                p.cout_devise,
                d.intitule as devise,
                sp.intitule as statut_projet,
                pr.intitule as priorite,
                it.intitule as institution_tutelle,
                cd.intitule as cadre_developpement,
                STRING_AGG(DISTINCT s.intitule, '; ') as secteurs,
                STRING_AGG(DISTINCT z.intitule, '; ') as zones_intervention,
                STRING_AGG(DISTINCT b.intitule, '; ') as bailleurs,
                COALESCE(SUM(ppf.montant), 0) as montant_plan_financement,
                COALESCE(
                    (SELECT SUM(pba1.montant) 
                     FROM projet_budget_annuels pba1 
                     WHERE pba1.plan_financement_id IN (
                         SELECT id FROM projet_plan_financements WHERE projet_id = p.id
                     ) AND pba1.statut_budget_id = 1 AND pba1.deleted_on IS NULL), 
                    0
                ) as budget_prevu_total,
                COALESCE(
                    (SELECT SUM(pba2.montant) 
                     FROM projet_budget_annuels pba2 
                     WHERE pba2.plan_financement_id IN (
                         SELECT id FROM projet_plan_financements WHERE projet_id = p.id
                     ) AND pba2.statut_budget_id = 2 AND pba2.deleted_on IS NULL), 
                    0
                ) as budget_depense_total,
                p.dispose_organe_pilotage,
                p.a_audit_regulier,
                p.problemes_rencontres,
                p.solutions_proposees,
                p.recommandations,
                p.rapport_rempli_par,
                p.rapport_date_remplissage
            FROM projets p
            LEFT JOIN statut_projets sp ON p.statut_projet_id = sp.id
            LEFT JOIN priorites pr ON p.priorite_id = pr.id
            LEFT JOIN institution_tutelles it ON p.institution_tutelle_id = it.id
            LEFT JOIN cadre_developpements cd ON p.cadre_developpement_id = cd.id
            LEFT JOIN devises d ON p.devise_id = d.id
            LEFT JOIN projet_secteur ps ON p.id = ps.projet_id
            LEFT JOIN secteurs s ON ps.secteur_id = s.id
            LEFT JOIN projet_zone pz ON p.id = pz.projet_id
            LEFT JOIN zones z ON pz.zone_id = z.id
            LEFT JOIN projet_plan_financements ppf ON p.id = ppf.projet_id AND ppf.deleted_on IS NULL
            LEFT JOIN bailleurs b ON ppf.bailleur_id = b.id
            WHERE p.deleted_on IS NULL
            GROUP BY p.id, p.sigle, p.intitule, p.annee_demarrage, p.date_debut_prevue, 
                     p.date_fin_prevue, p.date_debut_effective, p.date_fin_effective, 
                     p.date_approbation, p.date_signature, p.date_mise_en_vigueur,
                     p.duree, p.cout, p.cout_devise, d.intitule, sp.intitule, pr.intitule, 
                     it.intitule, cd.intitule, p.dispose_organe_pilotage, p.a_audit_regulier, 
                     p.problemes_rencontres, p.solutions_proposees, p.recommandations,
                     p.rapport_rempli_par, p.rapport_date_remplissage
            ORDER BY p.id
        ";
    }
    
    /**
     * Exporter le fichier plat des cadres stratégiques
     */
    public function exportCadresFichierPlat()
    {
        $sql = $this->getSQLCadresFichierPlat();
        
        $cadres = DB::select($sql);
        
        // Créer le fichier CSV
        $filename = 'cadres_strategiques_fichier_plat_' . date('Y-m-d_His') . '.csv';
        $filepath = storage_path('app/public/' . $filename);
        
        $file = fopen($filepath, 'w');
        
        // En-têtes
        if (count($cadres) > 0) {
            fputcsv($file, array_keys((array)$cadres[0]));
        }
        
        // Données
        foreach ($cadres as $cadre) {
            fputcsv($file, (array)$cadre);
        }
        
        fclose($file);
        
        return response()->download($filepath)->deleteFileAfterSend(true);
    }
    
    /**
     * Requête SQL pour fichier plat des cadres stratégiques
     * Format: Une ligne par indicateur avec toutes les informations remontant jusqu'au cadre
     */
    private function getSQLCadresFichierPlat()
    {
        return "
            SELECT 
                cd.id as cadre_id,
                cd.intitule as cadre_intitule,
                cd.structure_responsable,
                cd.annee_debut as cadre_annee_debut,
                cd.annee_fin as cadre_annee_fin,
                cl_impact.id as impact_id,
                cl_impact.intitule as impact_intitule,
                cl_impact.niveau as impact_niveau,
                cl_effet.id as effet_id,
                cl_effet.intitule as effet_intitule,
                cl_effet.niveau as effet_niveau,
                cl_produit.id as produit_id,
                cl_produit.intitule as produit_intitule,
                cl_produit.niveau as produit_niveau,
                ind.id as indicateur_id,
                ind.code as indicateur_code,
                ind.intitule as indicateur_intitule,
                ind.definition as indicateur_definition,
                ind.methode_calcul,
                ind.periodicite,
                ind.unite,
                STRING_AGG(DISTINCT d.intitule, '; ') as desagregations,
                STRING_AGG(DISTINCT p.intitule || ':' || di.valeur::text, '; ') as valeurs_annuelles,
                si.intitule as source_indicateur,
                ui.intitule as unite_indicateur
            FROM cadre_developpements cd
            -- Récupérer les orientations (impacts - niveau 1)
            INNER JOIN orientation_cadre_developpements ocd ON cd.id = ocd.cadre_developpement_id AND ocd.deleted_on IS NULL
            INNER JOIN cadre_logiques cl_impact ON ocd.cadre_logique_id = cl_impact.id AND cl_impact.niveau = 1 AND cl_impact.deleted_on IS NULL
            -- Récupérer les effets (niveau 2)
            LEFT JOIN cadre_logiques cl_effet ON cl_effet.cadre_logique_id = cl_impact.id AND cl_effet.niveau = 2 AND cl_effet.deleted_on IS NULL
            -- Récupérer les produits (niveau 3)
            LEFT JOIN cadre_logiques cl_produit ON cl_produit.cadre_logique_id = cl_effet.id AND cl_produit.niveau = 3 AND cl_produit.deleted_on IS NULL
            -- Récupérer les indicateurs liés aux différents niveaux
            LEFT JOIN cadre_mesure_resultats cmr ON cmr.cadre_logique_id IN (cl_impact.id, cl_effet.id, cl_produit.id) AND cmr.deleted_on IS NULL
            LEFT JOIN indicateurs ind ON cmr.indicateur_id = ind.id AND ind.deleted_on IS NULL
            -- Désagrégations
            LEFT JOIN desagregation_indicateur di_rel ON ind.id = di_rel.indicateur_id AND di_rel.deleted_on IS NULL
            LEFT JOIN desagregations d ON di_rel.desagregation_id = d.id AND d.deleted_on IS NULL
            -- Données des indicateurs
            LEFT JOIN donnee_indicateurs di ON ind.id = di.indicateur_id AND di.deleted_on IS NULL
            LEFT JOIN periodes p ON di.periode_id = p.id AND p.deleted_on IS NULL
            -- Autres informations
            LEFT JOIN source_indicateurs si ON ind.source = si.intitule
            LEFT JOIN unite_indicateurs ui ON ind.unite = ui.intitule
            WHERE cd.type_cadre_developpement_id = 1 AND cd.deleted_on IS NULL
            GROUP BY cd.id, cd.intitule, cd.structure_responsable, cd.annee_debut, cd.annee_fin,
                     cl_impact.id, cl_impact.intitule, cl_impact.niveau,
                     cl_effet.id, cl_effet.intitule, cl_effet.niveau,
                     cl_produit.id, cl_produit.intitule, cl_produit.niveau,
                     ind.id, ind.code, ind.intitule, ind.definition, ind.methode_calcul, 
                     ind.periodicite, ind.unite, si.intitule, ui.intitule
            ORDER BY cd.id, cl_impact.id, cl_effet.id, cl_produit.id, ind.id
        ";
    }
}
