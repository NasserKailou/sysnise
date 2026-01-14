<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeActiviteStoreRequest;
use App\Http\Requests\TypeActiviteUpdateRequest;
use App\Models\TypeActivite;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TypeActiviteController extends Controller
{
    public function index(Request $request)
    {
        $typeActivites = TypeActivite::whereNull('deleted_on')->get();

        return view('typeActivite.index', [
            'typeActivites' => $typeActivites,
			'breadcrumb' => 'Reférentiel > Types Activité',
        ]);
    }

    public function create(Request $request)
    {
        return view('typeActivite.create',[
			'breadcrumb' => 'Reférentiel > Nouveau Type Activité',
		]);
    }

    public function store(TypeActiviteStoreRequest $request)
    {
        $typeActivite = TypeActivite::create($request->validated());

        return redirect()->route('type_activites.index')->with('success', 'type activite créé avec succès');

    }

    public function show(Request $request, TypeActivite $typeActivite)
    {
        return view('typeActivite.show', [
            'typeActivite' => $typeActivite,
			'breadcrumb' => 'Reférentiel > Type Activité',
        ]);
    }

    public function edit(Request $request, TypeActivite $typeActivite)
    {
        return view('typeActivite.edit', [
            'typeActivite' => $typeActivite,
			'breadcrumb' => 'Reférentiel > Mise à jour Type Activité',
        ]);
    }

    public function update(TypeActiviteUpdateRequest $request, TypeActivite $typeActivite)
    {
        $typeActivite->update($request->validated());

        return redirect()->route('type_activites.index')->with('success', 'type activite modifié avec succès');
    }

    public function destroy(Request $request, TypeActivite $typeActivite)
    {
        $typeActivite->deleted_on = Carbon::now();
          $typeActivite->save();

        return redirect()->route('type_activites.index')->with('success', 'type activite supprimé avec succès');
    }
}
