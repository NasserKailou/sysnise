<?php

namespace App\Http\Controllers;

use App\Http\Requests\SecteurStoreRequest;
use App\Http\Requests\SecteurUpdateRequest;
use App\Models\Secteur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SecteurController extends Controller
{
    public function index(Request $request)
    {
        $secteurs = Secteur::all();

        return view('secteur.index', [
            'secteurs' => $secteurs,
			'breadcrumb' => 'Reférentiel > Priorités',
        ]);
    }

    public function create(Request $request)
    {
	return view('secteur.create',[
			'breadcrumb' => 'Reférentiel > Nouvelle Priorité',
		]);
    }

    public function store(SecteurStoreRequest $request)
    {
        $secteur = Secteur::create($request->validated());

        return redirect()->route('secteurs.index')->with('success', 'période créée avec succès');
       
    }

    public function show(Request $request, Secteur $secteur)
    {
        return view('secteur.show', [
            'secteur' => $secteur,
			'breadcrumb' => 'Reférentiel > Priorités',
        ]);
    }

    public function edit(Request $request, Secteur $secteur)
    {
        return view('secteur.edit', [
            'secteur' => $secteur,
			'breadcrumb' => 'Reférentiel > Mise à jour secteur',
        ]);
    }

    public function update(SecteurUpdateRequest $request, Secteur $secteur)
    {
        $secteur->update($request->validated());

        return redirect()->route('secteurs.index')->with('success', 'période modifiée avec succès');
    }

    public function destroy(Request $request, Secteur $secteur)
    {
        $secteur->delete();

        return redirect()->route('secteurs.index')->with('success', 'période supprimée avec succès');
    }
}
