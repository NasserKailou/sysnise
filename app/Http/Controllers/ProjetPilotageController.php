<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\ProjetPilotageAnnee;
use App\Models\ProjetPilotageSession;
use App\Models\ProjetAuditExercice;
use App\Models\ProjetRapport;
use App\Http\Requests\UpdateProjetGeneralRequest;
use App\Http\Requests\StorePilotageAnneeRequest;
use App\Http\Requests\UpdatePilotageAnneeRequest;
use App\Http\Requests\StoreAuditExerciceRequest;
use App\Http\Requests\UpdateAuditExerciceRequest;
use App\Http\Requests\StoreRapportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjetPilotageController extends Controller
{
    /**
     * Affiche la page de pilotage d'un projet.
     */
    public function show(Projet $projet)
    {
        // Charger les relations pour les afficher dans la vue
        $projet->load(['pilotageAnnees.sessions', 'auditsExercices', 'rapports']);

        return view('projet.pilotage', compact('projet'));
    }

    /**
     * Met à jour les champs généraux du projet (pilotage/audit booléens, textes).
     */
    public function updateGeneral(UpdateProjetGeneralRequest $request, Projet $projet)
    {


       // dd($projet);


        $projet->update($request->validated());



        return redirect()->route('projets.pilotage.show', $projet)
            ->with('success', 'Informations générales mises à jour.');
    }

    /**
     * Enregistre une nouvelle année de pilotage.
     */
    public function storePilotageAnnee(StorePilotageAnneeRequest $request, Projet $projet)
    {
        $data = $request->validated();
        $sessions = $data['sessions'] ?? [];
        unset($data['sessions']);

        // Créer l'année
        $annee = $projet->pilotageAnnees()->create($data);

        // Ajouter les sessions
        foreach ($sessions as $date) {
            if (!empty($date)) {
                $annee->sessions()->create(['date_session' => $date]);
            }
        }

        return redirect()->route('projets.pilotage.show', $projet)
            ->with('success', 'Année de pilotage ajoutée.');
    }

    /**
     * Affiche le formulaire d'édition d'une année de pilotage (via modal).
     */
    public function editPilotageAnnee(Projet $projet, ProjetPilotageAnnee $annee)
    {
        // Vérifier que l'année appartient bien au projet
        if ($annee->projet_id !== $projet->id) {
            abort(404);
        }

        $annee->load('sessions');
        return response()->json($annee);
    }

    /**
     * Met à jour une année de pilotage.
     */
    public function updatePilotageAnnee(UpdatePilotageAnneeRequest $request, Projet $projet, ProjetPilotageAnnee $annee)
    {
        if ($annee->projet_id !== $projet->id) {
            abort(404);
        }

        $data = $request->validated();
        $sessions = $data['sessions'] ?? [];
        unset($data['sessions']);

        $annee->update($data);

        // Remplacer les sessions : supprimer les anciennes, créer les nouvelles
        $annee->sessions()->delete();
        foreach ($sessions as $date) {
            if (!empty($date)) {
                $annee->sessions()->create(['date_session' => $date]);
            }
        }

        return redirect()->route('projets.pilotage.show', $projet)
            ->with('success', 'Année de pilotage mise à jour.');
    }

    /**
     * Supprime une année de pilotage.
     */
    public function destroyPilotageAnnee(Projet $projet, ProjetPilotageAnnee $annee)
    {
        if ($annee->projet_id !== $projet->id) {
            abort(404);
        }

        $annee->delete();

        return redirect()->route('projets.pilotage.show', $projet)
            ->with('success', 'Année de pilotage supprimée.');
    }

    /**
     * Enregistre un nouvel exercice d'audit.
     */
    public function storeAuditExercice(StoreAuditExerciceRequest $request, Projet $projet)
    {
        $projet->auditsExercices()->create($request->validated());

        return redirect()->route('projets.pilotage.show', $projet)
            ->with('success', 'Exercice d\'audit ajouté.');
    }

    /**
     * Affiche le formulaire d'édition d'un exercice d'audit.
     */
    public function editAuditExercice(Projet $projet, ProjetAuditExercice $exercice)
    {
        if ($exercice->projet_id !== $projet->id) {
            abort(404);
        }

        return response()->json($exercice);
    }

    /**
     * Met à jour un exercice d'audit.
     */
    public function updateAuditExercice(UpdateAuditExerciceRequest $request, Projet $projet, ProjetAuditExercice $exercice)
    {
        if ($exercice->projet_id !== $projet->id) {
            abort(404);
        }

        $exercice->update($request->validated());

        return redirect()->route('projets.pilotage.show', $projet)
            ->with('success', 'Exercice d\'audit mis à jour.');
    }

    /**
     * Supprime un exercice d'audit.
     */
    public function destroyAuditExercice(Projet $projet, ProjetAuditExercice $exercice)
    {
        if ($exercice->projet_id !== $projet->id) {
            abort(404);
        }

        $exercice->delete();

        return redirect()->route('projets.pilotage.show', $projet)
            ->with('success', 'Exercice d\'audit supprimé.');
    }

    /**
     * Enregistre un nouveau rapport (upload).
     */
    public function storeRapport(StoreRapportRequest $request, Projet $projet)
    {
        $data = $request->validated();

        // Gérer l'upload
        if ($request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('rapports/' . $projet->id, 'public');
            $data['fichier'] = $path;
        }

        $projet->rapports()->create($data);

        return redirect()->route('projets.pilotage.show', $projet)
            ->with('success', 'Rapport ajouté.');
    }

    /**
     * Supprime un rapport.
     */
    public function destroyRapport(Projet $projet, ProjetRapport $rapport)
    {
        if ($rapport->projet_id !== $projet->id) {
            abort(404);
        }

        // Supprimer le fichier
        Storage::disk('public')->delete($rapport->fichier);

        $rapport->delete();

        return redirect()->route('projets.pilotage.show', $projet)
            ->with('success', 'Rapport supprimé.');
    }
}