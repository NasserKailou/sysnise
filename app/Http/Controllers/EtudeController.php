<?php

namespace App\Http\Controllers;

use App\Http\Requests\EtudeStoreRequest;
use App\Http\Requests\EtudeUpdateRequest;
use App\Models\Etude;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EtudeController extends Controller
{
    public function index(Request $request)
    {
        $etudes = Etude::all();

        return view('etude.index', [
            'etudes' => $etudes,
			'breadcrumb' => 'Reférentiel > Etudes',
        ]);
    }

    public function create(Request $request)
    {
        return view('etude.create',[
		'breadcrumb' => 'Reférentiel > Nouvelle Etude',
		]);
    }

    public function store(EtudeStoreRequest $request)
    {
        $etude = Etude::create($request->validated());

        return redirect()->route('etudes.index')->with('success', 'période créée avec succès');
       
    }

    public function show(Request $request, Etude $etude)
    {
        return view('etude.show', [
            'etude' => $etude,
			'breadcrumb' => 'Reférentiel > Etudes',
        ]);
    }

    public function edit(Request $request, Etude $etude)
    {
        return view('etude.edit', [
            'etude' => $etude,
			'breadcrumb' => 'Reférentiel > Mise à jour Etude',
        ]);
    }

    public function update(EtudeUpdateRequest $request, Etude $etude)
    {
        $etude->update($request->validated());

        return redirect()->route('etudes.index')->with('success', 'période modifiée avec succès');
    }

    public function destroy(Request $request, Etude $etude)
    {
        $etude->delete();

        return redirect()->route('etudes.index')->with('success', 'période supprimée avec succès');
    }
}
