<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjetGouvernanceRequest;
use App\Http\Requests\UpdateProjetGouvernanceRequest;
use App\Models\Projet;
use App\Models\ProjetGouvernance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * CRUD de la fiche "Gouvernance" d'un projet.
 *
 * Toutes les routes sont imbriquées sous /projets/{projet}/gouvernance
 * afin que l'id du projet soit systématiquement passé en paramètre d'URL.
 */
class ProjetGouvernanceController extends Controller
{
    /**
     * Affiche la fiche gouvernance du projet (lecture seule),
     * ou invite à la créer si elle n'existe pas encore.
     */
    public function show(Projet $projet): View|RedirectResponse
    {
        $gouvernance = $projet->gouvernance()
            ->with(['sessions', 'audits', 'problems', 'recommendations'])
            ->first();

        if (! $gouvernance) {
            return redirect()
                ->route('projets.gouvernance.create', $projet)
                ->with('info', "Aucune fiche gouvernance n'existe encore pour ce projet.");
        }

        return view('gouvernance.show', compact('projet', 'gouvernance'));
    }

    /**
     * Formulaire de création de la fiche gouvernance.
     */
    public function create(Projet $projet): View|RedirectResponse
    {
        if ($projet->gouvernance()->exists()) {
            return redirect()->route('projets.gouvernance.edit', $projet);
        }

        return view('gouvernance.create', compact('projet'));
    }

    /**
     * Enregistre la fiche gouvernance et ses éléments liés (sessions, audits, problèmes, recommandations).
     */
    public function store(StoreProjetGouvernanceRequest $request, Projet $projet): RedirectResponse
    {
        if ($projet->gouvernance()->exists()) {
            return redirect()
                ->route('projets.gouvernance.edit', $projet)
                ->with('info', 'Une fiche gouvernance existe déjà pour ce projet, modifiez-la ici.');
        }

        $data = $request->validated();

        DB::transaction(function () use ($projet, $data) {
            $gouvernance = $projet->gouvernance()->create([
                'organe_pilotage_existe' => $data['organe_pilotage_existe'],
                'nb_sessions_prevues' => $data['nb_sessions_prevues'] ?? null,
                'nb_sessions_tenues' => $data['nb_sessions_tenues'] ?? null,
                'comptes_audites_regulierement' => $data['comptes_audites_regulierement'],
                'commentaire_audit' => $data['commentaire_audit'] ?? null,
                'rempli_par' => $data['rempli_par'] ?? null,
                'date_remplissage' => $data['date_remplissage'] ?? null,
            ]);

            $gouvernance->sessions()->createMany($data['sessions'] ?? []);
            $gouvernance->audits()->createMany($data['audits'] ?? []);
            $gouvernance->problems()->createMany($data['problems'] ?? []);
            $gouvernance->recommendations()->createMany($data['recommendations'] ?? []);
        });

        return redirect()
            ->route('projets.gouvernance.show', $projet)
            ->with('success', 'Fiche gouvernance créée avec succès.');
    }

    /**
     * Formulaire de modification de la fiche gouvernance.
     */
    public function edit(Projet $projet): View|RedirectResponse
    {
        $gouvernance = $projet->gouvernance()
            ->with(['sessions', 'audits', 'problems', 'recommendations'])
            ->first();

        if (! $gouvernance) {
            return redirect()->route('projets.gouvernance.create', $projet);
        }

        return view('gouvernance.edit', compact('projet', 'gouvernance'));
    }

    /**
     * Met à jour la fiche gouvernance : les sous-listes (sessions, audits, problèmes,
     * recommandations) sont resynchronisées (suppression puis recréation) pour rester
     * simples à gérer depuis un formulaire avec des lignes ajoutées/supprimées dynamiquement.
     */
    public function update(UpdateProjetGouvernanceRequest $request, Projet $projet): RedirectResponse
    {
        $gouvernance = $projet->gouvernance()->firstOrFail();
        $data = $request->validated();

        DB::transaction(function () use ($gouvernance, $data) {
            $gouvernance->update([
                'organe_pilotage_existe' => $data['organe_pilotage_existe'],
                'nb_sessions_prevues' => $data['nb_sessions_prevues'] ?? null,
                'nb_sessions_tenues' => $data['nb_sessions_tenues'] ?? null,
                'comptes_audites_regulierement' => $data['comptes_audites_regulierement'],
                'commentaire_audit' => $data['commentaire_audit'] ?? null,
                'rempli_par' => $data['rempli_par'] ?? null,
                'date_remplissage' => $data['date_remplissage'] ?? null,
            ]);

            $gouvernance->sessions()->delete();
            $gouvernance->sessions()->createMany($data['sessions'] ?? []);

            $gouvernance->audits()->delete();
            $gouvernance->audits()->createMany($data['audits'] ?? []);

            $gouvernance->problems()->delete();
            $gouvernance->problems()->createMany($data['problems'] ?? []);

            $gouvernance->recommendations()->delete();
            $gouvernance->recommendations()->createMany($data['recommendations'] ?? []);
        });

        return redirect()
            ->route('projets.gouvernance.show', $projet)
            ->with('success', 'Fiche gouvernance mise à jour avec succès.');
    }

    /**
     * Supprime entièrement la fiche gouvernance du projet (cascade sur les sous-listes).
     */
    public function destroy(Projet $projet): RedirectResponse
    {
        $projet->gouvernance()->delete();

        return redirect()
            ->route('projets.gouvernance.create', $projet)
            ->with('success', 'Fiche gouvernance supprimée.');
    }
}
