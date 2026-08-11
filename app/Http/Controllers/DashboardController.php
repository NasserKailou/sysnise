<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Projet;
use App\Models\CadreDeveloppement;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = "Tableau de Bord > Vue d'ensemble";

        $stats = $this->getGlobalStats();
        $chartsData = $this->getChartsData();
        $projetsFinancement = $this->getProjetsFinancement();
        $alertes = $this->getAlertes($projetsFinancement);

        return view('dashboard.index', compact(
            'breadcrumb',
            'stats',
            'chartsData',
            'projetsFinancement',
            'alertes'
        ));
    }

    private function getGlobalStats()
    {
        $totalFinancement = (float) DB::table('projet_plan_financements')
            ->whereNull('deleted_on')->sum('montant');

        $budgetPrevu = (float) DB::table('projet_budget_annuels')
            ->where('statut_budget_id', 3)
            ->whereNull('deleted_on')->sum('montant');

        $budgetDepense = (float) DB::table('projet_budget_annuels')
            ->where('statut_budget_id', 2)
            ->whereNull('deleted_on')->sum('montant');

        $tauxExecution = $budgetPrevu > 0 ? ($budgetDepense / $budgetPrevu) * 100 : 0;

        return [
            'total_projets' => Projet::whereNull('deleted_on')->count(),
            'projets_actifs' => Projet::join('statut_projets', 'projets.statut_projet_id', '=', 'statut_projets.id')
                ->where(function ($q) {
                    $q->whereRaw('LOWER(statut_projets.intitule) LIKE ?', ['%exécution%'])
                      ->orWhereRaw('LOWER(statut_projets.intitule) LIKE ?', ['%en cours%']);
                })
                ->whereNull('projets.deleted_on')->count(),
            'total_cadres' => CadreDeveloppement::where('type_cadre_developpement_id', 1)
                ->whereNull('deleted_on')->count(),
            'total_indicateurs' => DB::table('indicateurs')->count(),
            'total_financement' => $totalFinancement,
            'total_budget_prevu' => $budgetPrevu,
            'total_budget_depense' => $budgetDepense,
            'taux_execution' => $tauxExecution,
        ];
    }

    private function getChartsData()
    {
        return [
            'financement_par_secteur' => $this->getFinancementParSecteur(),
            'financement_par_region' => $this->getFinancementParRegion(),
            'projets_par_statut' => $this->getProjetsParStatut(),
            'financement_par_bailleur' => $this->getFinancementParBailleur(),
            'evolution_budgets' => $this->getEvolutionBudgets(),
        ];
    }

    private function getFinancementParSecteur()
    {
        return DB::table('projet_plan_financements as ppf')
            ->join('projets as p', 'ppf.projet_id', '=', 'p.id')
            ->join('projet_secteur as ps', 'p.id', '=', 'ps.projet_id')
            ->join('secteurs as s', 'ps.secteur_id', '=', 's.id')
            ->select('s.intitule as secteur', DB::raw('SUM(ppf.montant) as montant'))
            ->whereNull('ppf.deleted_on')->whereNull('p.deleted_on')
            ->groupBy('s.id', 's.intitule')->orderByDesc('montant')->get();
    }

    private function getFinancementParRegion()
    {
        return DB::table('projet_plan_financements as ppf')
            ->join('projets as p', 'ppf.projet_id', '=', 'p.id')
            ->join('projet_zone as pz', 'p.id', '=', 'pz.projet_id')
            ->join('zones as z', 'pz.zone_id', '=', 'z.id')
            ->select('z.intitule as region', DB::raw('SUM(ppf.montant) as montant'))
            ->where('z.niveau', 2)->whereNull('ppf.deleted_on')->whereNull('p.deleted_on')
            ->groupBy('z.id', 'z.intitule')->orderByDesc('montant')->get();
    }

    private function getProjetsParStatut()
    {
        return DB::table('projets as p')
            ->join('statut_projets as sp', 'p.statut_projet_id', '=', 'sp.id')
            ->select('sp.intitule as statut', DB::raw('COUNT(*) as nombre'))
            ->whereNull('p.deleted_on')
            ->groupBy('sp.id', 'sp.intitule')->orderByDesc('nombre')->get();
    }

    private function getFinancementParBailleur()
    {
        return DB::table('projet_plan_financements as ppf')
            ->join('bailleurs as b', 'ppf.bailleur_id', '=', 'b.id')
            ->select('b.intitule as bailleur', DB::raw('SUM(ppf.montant) as montant'))
            ->whereNull('ppf.deleted_on')
            ->groupBy('b.id', 'b.intitule')->orderByDesc('montant')->limit(10)->get();
    }

    private function getEvolutionBudgets()
    {
        return DB::table('projet_budget_annuels as pba')
            ->join('statut_budgets as sb', 'pba.statut_budget_id', '=', 'sb.id')
            ->select('pba.annee', 'sb.intitule as type', DB::raw('SUM(pba.montant) as montant'))
            ->whereNull('pba.deleted_on')
            ->groupBy('pba.annee', 'sb.id', 'sb.intitule')
            ->orderBy('pba.annee')->get();
    }

    private function getProjetsFinancement()
    {
        return DB::table('projets as p')
            ->leftJoin('statut_projets as sp', 'p.statut_projet_id', '=', 'sp.id')
            ->leftJoin('institution_tutelles as it', 'p.institution_tutelle_id', '=', 'it.id')
            ->leftJoin('projet_secteur as ps', 'p.id', '=', 'ps.projet_id')
            ->leftJoin('secteurs as s', 'ps.secteur_id', '=', 's.id')
            ->select(
                'p.id', 'p.sigle', 'p.intitule', 'p.date_debut_prevue', 'p.date_fin_prevue',
                'sp.intitule as statut', 'it.intitule as institution_tutelle',
                DB::raw("STRING_AGG(DISTINCT s.intitule, ', ') as secteurs"),
                DB::raw('COALESCE(p.cout, 0) as financement_prevu'),
                DB::raw("COALESCE((
                    SELECT SUM(pba.montant)
                    FROM projet_budget_annuels pba
                    JOIN projet_plan_financements ppf ON pba.plan_financement_id = ppf.id
                    WHERE ppf.projet_id = p.id AND pba.statut_budget_id = 3
                    AND pba.deleted_on IS NULL AND ppf.deleted_on IS NULL
                ), 0) as budget_budgetise"),
                DB::raw("COALESCE((
                    SELECT SUM(pba.montant)
                    FROM projet_budget_annuels pba
                    JOIN projet_plan_financements ppf ON pba.plan_financement_id = ppf.id
                    WHERE ppf.projet_id = p.id AND pba.statut_budget_id = 2
                    AND pba.deleted_on IS NULL AND ppf.deleted_on IS NULL
                ), 0) as budget_depense"),
                DB::raw("CASE WHEN COALESCE((
                    SELECT SUM(pba.montant)
                    FROM projet_budget_annuels pba
                    JOIN projet_plan_financements ppf ON pba.plan_financement_id = ppf.id
                    WHERE ppf.projet_id = p.id AND pba.statut_budget_id = 3
                    AND pba.deleted_on IS NULL AND ppf.deleted_on IS NULL
                ), 0) = 0 THEN 0 ELSE ROUND((
                    COALESCE((
                        SELECT SUM(pba.montant)
                        FROM projet_budget_annuels pba
                        JOIN projet_plan_financements ppf ON pba.plan_financement_id = ppf.id
                        WHERE ppf.projet_id = p.id AND pba.statut_budget_id = 2
                        AND pba.deleted_on IS NULL AND ppf.deleted_on IS NULL
                    ), 0) * 100.0 / NULLIF((
                        SELECT SUM(pba.montant)
                        FROM projet_budget_annuels pba
                        JOIN projet_plan_financements ppf ON pba.plan_financement_id = ppf.id
                        WHERE ppf.projet_id = p.id AND pba.statut_budget_id = 3
                        AND pba.deleted_on IS NULL AND ppf.deleted_on IS NULL
                    ), 0)), 2) END as taux_consommation")
            )
            ->whereNull('p.deleted_on')
            ->groupBy('p.id', 'p.sigle', 'p.intitule', 'p.cout', 'p.date_debut_prevue',
                'p.date_fin_prevue', 'sp.intitule', 'it.intitule')
            ->orderBy('p.intitule')->get();
    }

    private function getAlertes($projets)
    {
        $today = now()->startOfDay();
        return $projets->map(function ($p) use ($today) {
            $execution = (float) ($p->taux_consommation ?? 0);
            $debut = $p->date_debut_prevue ? \Carbon\Carbon::parse($p->date_debut_prevue) : null;
            $fin = $p->date_fin_prevue ? \Carbon\Carbon::parse($p->date_fin_prevue) : null;

            $temps = null;
            if ($debut && $fin && $fin->gt($debut)) {
                $total = max(1, $debut->diffInDays($fin));
                $elapsed = max(0, min($total, $debut->diffInDays($today)));
                $temps = round(($elapsed / $total) * 100, 1);
            }

            $niveau = null;
            $message = null;
            if ($temps !== null && $temps >= 70 && $execution < 40) {
                $niveau = 'critique';
                $message = 'Avancement financier très inférieur au calendrier';
            } elseif ($temps !== null && $temps >= 50 && $execution < 50) {
                $niveau = 'attention';
                $message = 'Exécution financière à surveiller';
            } elseif ($fin && $fin->lt($today) && $execution < 80) {
                $niveau = 'critique';
                $message = 'Date de fin dépassée avec exécution insuffisante';
            }

            if (!$niveau) return null;

            return [
                'id' => $p->id,
                'sigle' => $p->sigle,
                'intitule' => $p->intitule,
                'niveau' => $niveau,
                'message' => $message,
                'execution' => $execution,
                'temps' => $temps,
            ];
        })->filter()->sortByDesc(fn ($a) => $a['niveau'] === 'critique')->values();
    }

    public function exportProjetsFichierPlat()
    {
        $rows = DB::table('projets as p')
            ->leftJoin('statut_projets as sp', 'p.statut_projet_id', '=', 'sp.id')
            ->leftJoin('institution_tutelles as it', 'p.institution_tutelle_id', '=', 'it.id')
            ->select('p.id as projet_id', 'p.sigle', 'p.intitule', 'p.annee_demarrage',
                'p.date_debut_prevue', 'p.date_fin_prevue', 'p.cout',
                'sp.intitule as statut', 'it.intitule as institution_tutelle')
            ->whereNull('p.deleted_on')->orderBy('p.id')->get();

        return $this->downloadCsv($rows, 'projets_fichier_plat_');
    }

    public function exportCadresFichierPlat()
    {
        $rows = DB::table('cadre_developpements as cd')
            ->select('cd.id as cadre_id', 'cd.intitule', 'cd.structure_responsable',
                'cd.annee_debut', 'cd.annee_fin')
            ->where('cd.type_cadre_developpement_id', 1)
            ->whereNull('cd.deleted_on')->orderBy('cd.id')->get();

        return $this->downloadCsv($rows, 'cadres_strategiques_');
    }

    private function downloadCsv($rows, $prefix)
    {
        $filename = $prefix . date('Y-m-d_His') . '.csv';
        $filepath = storage_path('app/public/' . $filename);

        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0775, true);
        }

        $file = fopen($filepath, 'w');
        if ($rows->count()) {
            fputcsv($file, array_keys((array) $rows->first()));
            foreach ($rows as $row) fputcsv($file, (array) $row);
        }
        fclose($file);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }
}
