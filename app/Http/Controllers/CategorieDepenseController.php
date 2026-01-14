<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieDepenseStoreRequest;
use App\Http\Requests\CategorieDepenseUpdateRequest;
use App\Models\CategorieDepense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategorieDepenseController extends Controller
{
    public function index(Request $request)
    {
        $categorieDepenses = CategorieDepense::all();

        return view('categorieDepense.index', [
            'categorieDepenses' => $categorieDepenses,
			'breadcrumb' => 'Reférentiel > Statuts Activité',
        ]);
    }

    public function create(Request $request)
    {
        return view('categorieDepense.create',[
			'breadcrumb' => 'Reférentiel > Nouveau Statut Activité',
		]);
    }

    public function store(CategorieDepenseStoreRequest $request)
    {
        $categorieDepense = CategorieDepense::create($request->validated());

        return redirect()->route('categorie_depenses.index')->with('success', 'catégotrie dépense créée avec succès');
       
    }

    public function show(Request $request, CategorieDepense $categorieDepense)
    {
        return view('categorieDepense.show', [
            'categorieDepense' => $categorieDepense,
			'breadcrumb' => 'Reférentiel > Statut Activité',
        ]);
    }

    public function edit(Request $request, CategorieDepense $categorieDepense)
    {
        return view('categorieDepense.edit', [
            'categorieDepense' => $categorieDepense,
			'breadcrumb' => 'Reférentiel > Mise à jour catégorie dépense',
        ]);
    }

    public function update(CategorieDepenseUpdateRequest $request, CategorieDepense $categorieDepense)
    {
        $categorieDepense->update($request->validated());

        return redirect()->route('categorie_depenses.index')->with('success', 'catégotrie dépense modifiée avec succès');
    }

    public function destroy(Request $request, CategorieDepense $categorieDepense)
    {
        $categorieDepense->delete();

        return redirect()->route('categorie_depenses.index')->with('success', 'catégotrie dépense supprimée avec succès');
    }
}
