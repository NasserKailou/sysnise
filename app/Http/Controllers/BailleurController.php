<?php

namespace App\Http\Controllers;

use App\Http\Requests\BailleurStoreRequest;
use App\Http\Requests\BailleurUpdateRequest;
use App\Models\Bailleur;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BailleurController extends Controller
{
    public function index(Request $request)
    {
        $bailleurs = Bailleur::whereNull('deleted_on')->get();

        return view('bailleur.index', [
            'bailleurs' => $bailleurs,
			'breadcrumb' => 'Reférentiel > Bailleurs',
        ]);
    }

    public function create(Request $request)
    {
	return view('bailleur.create',[
			'breadcrumb' => 'Reférentiel > Nouveau Bailleur',
		]);
    }

    public function store(BailleurStoreRequest $request)
    {
        $bailleur = Bailleur::create($request->validated());

        return redirect()->route('bailleurs.index')->with('success', 'Bailleur créé avec succès');
       
    }

    public function show(Request $request, Bailleur $bailleur)
    {
        return view('bailleur.show', [
            'bailleur' => $bailleur,
			'breadcrumb' => 'Reférentiel > Bailleur',
        ]);
    }

    public function edit(Request $request, Bailleur $bailleur)
    {
        return view('bailleur.edit', [
            'bailleur' => $bailleur,
			'breadcrumb' => 'Reférentiel > Mise à jour Bailleur',
        ]);
    }

    public function update(BailleurUpdateRequest $request, Bailleur $bailleur)
    {
        $bailleur->update($request->validated());

        return redirect()->route('bailleurs.index')->with('success', 'Bailleur modifié avec succès');
    }

    public function destroy(Request $request, Bailleur $bailleur)
    {
        $bailleur->deleted_on = Carbon::now();
          $bailleur->save();

        return redirect()->route('bailleurs.index')->with('success', 'Bailleur supprimé avec succès');
    }
}
