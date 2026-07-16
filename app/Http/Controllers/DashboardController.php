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
        
        return view('dashboard.index', compact('breadcrumb', 'stats', 'chartsData'));
    }
    
    /**
     * Obtenir les statistiques globales
     */
    private function getGlobalStats()
    {
        return [
            'total_projets' => Projet::count(),
            'total_cadres' => CadreDeveloppement::where('type_cadre_developpement_id', 1)->count(),
            'total_financement' => DB::table('projet_plan_financements')->sum('montant'),
            'total_budget_prevu' => DB::table('projet_budget_annuels')
                ->where('statut_budget_id', 1)
                ->sum('montant'),
            'total_budget_depense' => DB::table('projet_budget_annuels')
                ->where('statut_budget_id', 2)
                ->sum('montant'),
            'projets_actifs' => Projet::whereHas('statutProjet', function($q) {
                $q->where('intitule', 'like', '%actif%')
                    ->orWhere('intitule', 'like', '%cours%');
            })->count(),
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
            ->where('z.type_zone', 'region')
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
                p.duree,
                p.cout as cout_total,
                d.sigle as devise,
                sp.intitule as statut_projet,
                pr.intitule as priorite,
                it.intitule as institution_tutelle,
                cd.intitule as cadre_developpement,
                GROUP_CONCAT(DISTINCT s.intitule SEPARATOR '; ') as secteurs,
                GROUP_CONCAT(DISTINCT z.intitule SEPARATOR '; ') as zones_intervention,
                GROUP_CONCAT(DISTINCT b.intitule SEPARATOR '; ') as bailleurs,
                COALESCE(SUM(ppf.montant), 0) as montant_plan_financement,
                COALESCE(
                    (SELECT SUM(pba1.montant) 
                     FROM projet_budget_annuels pba1 
                     WHERE pba1.plan_financement_id IN (
                         SELECT id FROM projet_plan_financements WHERE projet_id = p.id
                     ) AND pba1.statut_budget_id = 1), 
                    0
                ) as budget_prevu_total,
                COALESCE(
                    (SELECT SUM(pba2.montant) 
                     FROM projet_budget_annuels pba2 
                     WHERE pba2.plan_financement_id IN (
                         SELECT id FROM projet_plan_financements WHERE projet_id = p.id
                     ) AND pba2.statut_budget_id = 2), 
                    0
                ) as budget_depense_total,
                p.dispose_organe_pilotage,
                p.a_audit_regulier,
                p.problemes_rencontres,
                p.solutions_proposees,
                p.recommandations
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
            LEFT JOIN projet_plan_financements ppf ON p.id = ppf.projet_id
            LEFT JOIN bailleurs b ON ppf.bailleur_id = b.id
            GROUP BY p.id, p.sigle, p.intitule, p.annee_demarrage, p.date_debut_prevue, 
                     p.date_fin_prevue, p.date_debut_effective, p.date_fin_effective, 
                     p.duree, p.cout, d.sigle, sp.intitule, pr.intitule, it.intitule, 
                     cd.intitule, p.dispose_organe_pilotage, p.a_audit_regulier, 
                     p.problemes_rencontres, p.solutions_proposees, p.recommandations
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
                GROUP_CONCAT(DISTINCT d.intitule SEPARATOR '; ') as desagregations,
                GROUP_CONCAT(DISTINCT CONCAT(di.annee, ':', di.valeur) SEPARATOR '; ') as valeurs_annuelles,
                si.intitule as source_indicateur,
                ui.intitule as unite_indicateur
            FROM cadre_developpements cd
            -- Récupérer les orientations (impacts - niveau 1)
            INNER JOIN orientation_cadre_developpements ocd ON cd.id = ocd.cadre_developpement_id
            INNER JOIN cadre_logiques cl_impact ON ocd.cadre_logique_id = cl_impact.id AND cl_impact.niveau = 1
            -- Récupérer les effets (niveau 2)
            LEFT JOIN cadre_logiques cl_effet ON cl_effet.cadre_logique_id = cl_impact.id AND cl_effet.niveau = 2
            -- Récupérer les produits (niveau 3)
            LEFT JOIN cadre_logiques cl_produit ON cl_produit.cadre_logique_id = cl_effet.id AND cl_produit.niveau = 3
            -- Récupérer les indicateurs liés aux différents niveaux
            LEFT JOIN cadre_mesure_resultats cmr ON cmr.cadre_logique_id IN (cl_impact.id, cl_effet.id, cl_produit.id)
            LEFT JOIN indicateurs ind ON cmr.indicateur_id = ind.id
            -- Désagrégations
            LEFT JOIN desagregation_indicateur di_rel ON ind.id = di_rel.indicateur_id
            LEFT JOIN desagregations d ON di_rel.desagregation_id = d.id
            -- Données des indicateurs
            LEFT JOIN donnee_indicateurs di ON ind.id = di.indicateur_id
            -- Autres informations
            LEFT JOIN source_indicateurs si ON ind.source = si.id
            LEFT JOIN unite_indicateurs ui ON ind.unite = ui.id
            WHERE cd.type_cadre_developpement_id = 1
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
