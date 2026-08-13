<?php

namespace App\Http\Controllers;

use App\Models\GovernanceAudit;
use App\Models\GovernanceAuditExercice;
use App\Models\GovernanceAuditRecommandation;
use App\Models\GovernancePilotage;
use App\Models\GovernancePilotageRecommandation;
use App\Models\GovernancePilotageSession;
use App\Models\GovernanceProbleme;
use App\Models\GovernanceRecommandation;
use App\Models\GovernanceSolution;
use App\Models\Projet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjetGovernanceController extends Controller
{
    /**
     * Affiche la fiche gouvernance du projet (pilotage, audits,
     * problèmes/solutions, recommandations).
     */
    public function index(Projet $projet): View
    {
        $projet->loadMissing([
            'governancePilotage.sessions.recommandations',
            'governanceAudit.exercices.recommandations',
            'governanceProblemes.solutions',
            'governanceRecommandations',
        ]);

        return view('governance.index', [
            'breadcrumb' => 'Gouvernance du projet : '.$projet->intitule,
			'projet' => $projet,
            'pilotage' => $projet->governancePilotage,
            'audit' => $projet->governanceAudit,
            'problemes' => $projet->governanceProblemes,
            'recommandations' => $projet->governanceRecommandations->groupBy('destinataire'),
        ]);
    }

    /* -----------------------------------------------------------------
     |  3.1 Pilotage
     | -----------------------------------------------------------------
     */

    public function updatePilotage(Request $request, Projet $projet): RedirectResponse
    {
        $data = $request->validate([
            'dispose_organe_pilotage' => ['required', 'boolean'],
            'nombre_sessions_prevues' => ['nullable', 'integer', 'min:0'],
            'nombre_sessions_tenues' => ['nullable', 'integer', 'min:0'],
        ]);

        $projet->governancePilotage()->updateOrCreate(
            ['projet_id' => $projet->id],
            $data
        );

        return back()->with('status', "Organe de pilotage mis à jour.");
    }

    public function storeSession(Request $request, Projet $projet): RedirectResponse
    {
        $data = $request->validate([
            'date_session' => ['required', 'date'],
        ]);

        $pilotage = $projet->governancePilotage()->firstOrCreate(['projet_id' => $projet->id]);

        $pilotage->sessions()->create($data);

        return back()->with('status', 'Session de pilotage ajoutée.');
    }

    public function destroySession(Projet $projet, GovernancePilotageSession $session): RedirectResponse
    {
        $session->delete();

        return back()->with('status', 'Session de pilotage supprimée.');
    }

    public function storeSessionRecommandation(Request $request, Projet $projet, GovernancePilotageSession $session): RedirectResponse
    {
        $data = $request->validate([
            'libelle' => ['required', 'string'],
            'est_realisee' => ['nullable', 'boolean'],
        ]);
        $data['est_realisee'] = $request->boolean('est_realisee');

        $session->recommandations()->create($data);

        return back()->with('status', 'Recommandation ajoutée à la session.');
    }

    public function toggleSessionRecommandation(Projet $projet, GovernancePilotageRecommandation $recommandation): RedirectResponse
    {
        $recommandation->update(['est_realisee' => ! $recommandation->est_realisee]);

        return back()->with('status', 'Statut de la recommandation mis à jour.');
    }

    public function destroySessionRecommandation(Projet $projet, GovernancePilotageRecommandation $recommandation): RedirectResponse
    {
        $recommandation->delete();

        return back()->with('status', 'Recommandation supprimée.');
    }

    /* -----------------------------------------------------------------
     |  3.2 Audits
     | -----------------------------------------------------------------
     */

    public function updateAudit(Request $request, Projet $projet): RedirectResponse
    {
        $data = $request->validate([
            'comptes_audites' => ['required', 'boolean'],
            'nombre_audits_realises' => ['nullable', 'integer', 'min:0'],
            'commentaire' => ['nullable', 'string'],
        ]);

        $projet->governanceAudit()->updateOrCreate(
            ['projet_id' => $projet->id],
            $data
        );

        return back()->with('status', 'Section audits mise à jour.');
    }

    public function storeAuditExercice(Request $request, Projet $projet): RedirectResponse
    {
        $data = $request->validate([
            'exercice_comptable' => ['required', 'string', 'max:50'],
            'comptes_certifies_sans_reserves' => ['required', 'boolean'],
        ]);

        $audit = $projet->governanceAudit()->firstOrCreate(['projet_id' => $projet->id]);

        $audit->exercices()->create($data);

        return back()->with('status', 'Exercice comptable ajouté.');
    }

    public function destroyAuditExercice(Projet $projet, GovernanceAuditExercice $exercice): RedirectResponse
    {
        $exercice->delete();

        return back()->with('status', 'Exercice comptable supprimé.');
    }

    public function storeAuditRecommandation(Request $request, Projet $projet, GovernanceAuditExercice $exercice): RedirectResponse
    {
        $data = $request->validate([
            'libelle' => ['required', 'string'],
            'est_realisee' => ['nullable', 'boolean'],
        ]);
        $data['est_realisee'] = $request->boolean('est_realisee');

        $exercice->recommandations()->create($data);

        return back()->with('status', "Recommandation ajoutée à l'exercice.");
    }

    public function toggleAuditRecommandation(Projet $projet, GovernanceAuditRecommandation $recommandation): RedirectResponse
    {
        $recommandation->update(['est_realisee' => ! $recommandation->est_realisee]);

        return back()->with('status', 'Statut de la recommandation mis à jour.');
    }

    public function destroyAuditRecommandation(Projet $projet, GovernanceAuditRecommandation $recommandation): RedirectResponse
    {
        $recommandation->delete();

        return back()->with('status', 'Recommandation supprimée.');
    }

    /* -----------------------------------------------------------------
     |  IV.1 Problèmes rencontrés et solutions proposées
     | -----------------------------------------------------------------
     */

    public function storeProbleme(Request $request, Projet $projet): RedirectResponse
    {
        $data = $request->validate([
            'libelle' => ['required', 'string'],
        ]);

        $projet->governanceProblemes()->create($data);

        return back()->with('status', 'Problème ajouté.');
    }

    public function destroyProbleme(Projet $projet, GovernanceProbleme $probleme): RedirectResponse
    {
        $probleme->delete();

        return back()->with('status', 'Problème supprimé.');
    }

    public function storeSolution(Request $request, Projet $projet, GovernanceProbleme $probleme): RedirectResponse
    {
        $data = $request->validate([
            'libelle' => ['required', 'string'],
        ]);

        $probleme->solutions()->create($data);

        return back()->with('status', 'Solution ajoutée.');
    }

    public function destroySolution(Projet $projet, GovernanceSolution $solution): RedirectResponse
    {
        $solution->delete();

        return back()->with('status', 'Solution supprimée.');
    }

    /* -----------------------------------------------------------------
     |  IV.2 Recommandations (Directeur / structures partenaires, etc.)
     | -----------------------------------------------------------------
     */

    public function storeRecommandation(Request $request, Projet $projet): RedirectResponse
    {
        $data = $request->validate([
            'destinataire' => ['required', 'string', 'max:255'],
            'libelle' => ['required', 'string'],
        ]);

        $projet->governanceRecommandations()->create($data);

        return back()->with('status', 'Recommandation ajoutée.');
    }

    public function destroyRecommandation(Projet $projet, GovernanceRecommandation $recommandation): RedirectResponse
    {
        $recommandation->delete();

        return back()->with('status', 'Recommandation supprimée.');
    }
}
