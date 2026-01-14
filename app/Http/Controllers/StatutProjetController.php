<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatutProjetStoreRequest;
use App\Http\Requests\StatutProjetUpdateRequest;
use App\Models\StatutProjet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatutProjetController extends Controller
{
    public function index(Request $request)
    {
        $statutProjets = StatutProjet::all();

        return view('statutProjet.index', [
            'statutProjets' => $statutProjets,
			'breadcrumb' => 'Reférentiel > Statuts Projet',
        ]);
    }

    public function create(Request $request)
    {
        return view('statutProjet.create',[
			'breadcrumb' => 'Reférentiel > Nouveau Statut Projet',
		]);
    }

    public function store(StatutProjetStoreRequest $request)
    {
        $statutProjet = StatutProjet::create($request->validated());

        return redirect()->route('statut_projets.index')->with('success', 'statut projet créé avec succès');

    }

    public function show(Request $request, StatutProjet $statutProjet)
    {
        return view('statutProjet.show', [
            'statutProjet' => $statutProjet,
			'breadcrumb' => 'Reférentiel > Statut Projet',
        ]);
    }

    public function edit(Request $request, StatutProjet $statutProjet)
    {
        return view('statutProjet.edit', [
            'statutProjet' => $statutProjet,
			'breadcrumb' => 'Reférentiel > Mise à jour Statut Projet',
        ]);
    }

    public function update(StatutProjetUpdateRequest $request, StatutProjet $statutProjet)
    {
        $statutProjet->update($request->validated());

        return redirect()->route('statut_projets.index')->with('success', 'statut projet modifié avec succès');
    }

    public function destroy(Request $request, StatutProjet $statutProjet)
    {
        $statutProjet->delete();

        return redirect()->route('statut_projets.index')->with('success', 'statut projet supprimé avec succès');
    }
}
