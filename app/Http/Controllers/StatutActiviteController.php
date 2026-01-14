<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatutActiviteStoreRequest;
use App\Http\Requests\StatutActiviteUpdateRequest;
use App\Models\StatutActivite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatutActiviteController extends Controller
{
    public function index(Request $request)
    {
        $statutActivites = StatutActivite::all();

        return view('statutActivite.index', [
            'statutActivites' => $statutActivites,
			'breadcrumb' => 'Reférentiel > Statuts Activité',
        ]);
    }

    public function create(Request $request)
    {
        return view('statutActivite.create',[
			'breadcrumb' => 'Reférentiel > Nouveau Statut Activité',
		]);
    }

    public function store(StatutActiviteStoreRequest $request)
    {
        $statutActivite = StatutActivite::create($request->validated());

        return redirect()->route('statut_activites.index')->with('success', 'statut activite créé avec succès');

    }

    public function show(Request $request, StatutActivite $statutActivite)
    {
        return view('statutActivite.show', [
            'statutActivite' => $statutActivite,
			'breadcrumb' => 'Reférentiel > Statut Activité',
        ]);
    }

    public function edit(Request $request, StatutActivite $statutActivite)
    {
        return view('statutActivite.edit', [
            'statutActivite' => $statutActivite,
			'breadcrumb' => 'Reférentiel > Mise à jour Statut Activité',
        ]);
    }

    public function update(StatutActiviteUpdateRequest $request, StatutActivite $statutActivite)
    {
        $statutActivite->update($request->validated());

        return redirect()->route('statut_activites.index')->with('success', 'statut activite modifié avec succès');
    }

    public function destroy(Request $request, StatutActivite $statutActivite)
    {
        $statutActivite->delete();

        return redirect()->route('statut_activites.index')->with('success', 'statut activite supprimé avec succès');
    }
}
