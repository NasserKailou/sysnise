<?php

namespace App\Http\Controllers;

use App\Http\Requests\PopulationCibleStoreRequest;
use App\Http\Requests\PopulationCibleUpdateRequest;
use App\Models\PopulationCible;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PopulationCibleController extends Controller
{
    public function index(Request $request)
    {
        $populationCibles = PopulationCible::all();

        return view('populationCible.index', [
            'populationCibles' => $populationCibles,
			'breadcrumb' => 'Reférentiel > Populations Cibles',
        ]);
    }

    public function create(Request $request)
    {
        return view('populationCible.create',[
			'breadcrumb' => 'Reférentiel > Nouvelle Population Cible',
		]);
    }

    public function store(PopulationCibleStoreRequest $request)
    {
        $populationCible = PopulationCible::create($request->validated());

        return redirect()->route('population_cibles.index')->with('success', 'mode de financement créée avec succès');
       
    }

    public function show(Request $request, PopulationCible $populationCible)
    {
        return view('populationCible.show', [
            'populationCible' => $populationCible,
			'breadcrumb' => 'Reférentiel > Populations Cibles',
        ]);
    }

    public function edit(Request $request, PopulationCible $populationCible)
    {
        return view('populationCible.edit', [
            'populationCible' => $populationCible,
			'breadcrumb' => 'Reférentiel > Mise à jour Population Cible',
        ]);
    }

    public function update(PopulationCibleUpdateRequest $request, PopulationCible $populationCible)
    {
        $populationCible->update($request->validated());

        return redirect()->route('population_cibles.index')->with('success', 'mode de financement modifiée avec succès');
    }

    public function destroy(Request $request, PopulationCible $populationCible)
    {
        $populationCible->delete();

        return redirect()->route('population_cibles.index')->with('success', 'mode de financement supprimée avec succès');
    }
}
