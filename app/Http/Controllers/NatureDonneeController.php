<?php

namespace App\Http\Controllers;

use App\Http\Requests\NatureDonneeStoreRequest;
use App\Http\Requests\NatureDonneeUpdateRequest;
use App\Models\NatureDonnee;
use Carbon\Carbon;
use Date;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NatureDonneeController extends Controller
{
    public function index(Request $request)
    {
        $natureDonnees = NatureDonnee::whereNull('deleted_on')->get();

        return view('natureDonnee.index', [
            'natureDonnees' => $natureDonnees,
			'breadcrumb' => 'Reférentiel > Natures Données',
        ]);
    }

    public function create(Request $request)
    {
        return view('natureDonnee.create',[
		'breadcrumb' => 'Reférentiel > Nouvelle Nature Donnée',
		]);
    }

    public function store(NatureDonneeStoreRequest $request)
    {
        $natureDonnee = NatureDonnee::create($request->validated());

        return redirect()->route('nature_donnees.index')->with('success', 'nature donnée créée avec succès');

    }

    public function show(Request $request, NatureDonnee $natureDonnee)
    {
        return view('natureDonnee.show', [
            'natureDonnee' => $natureDonnee,
			'breadcrumb' => 'Reférentiel > Natures Données',
        ]);
    }

    public function edit(Request $request, NatureDonnee $natureDonnee)
    {
        return view('natureDonnee.edit', [
            'natureDonnee' => $natureDonnee,
			'breadcrumb' => 'Reférentiel > Mise à jour Nature Donnée',
        ]);
    }

    public function update(NatureDonneeUpdateRequest $request, NatureDonnee $natureDonnee)
    {
        $natureDonnee->update($request->validated());

        return redirect()->route('nature_donnees.index')->with('success', 'nature donnée modifiée avec succès');
    }

    public function destroy(Request $request, NatureDonnee $natureDonnee)
    {
          $natureDonnee->deleted_on = Carbon::now();
          $natureDonnee->save();

        return redirect()->route('nature_donnees.index')->with('success', 'nature donnée supprimée avec succès');
    }
}
