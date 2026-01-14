<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrioriteStoreRequest;
use App\Http\Requests\PrioriteUpdateRequest;
use App\Models\Priorite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrioriteController extends Controller
{
    public function index(Request $request)
    {
        $priorites = Priorite::all();

        return view('priorite.index', [
            'priorites' => $priorites,
			'breadcrumb' => 'Reférentiel > Priorités',
        ]);
    }

    public function create(Request $request)
    {
	return view('priorite.create',[
			'breadcrumb' => 'Reférentiel > Nouvelle Priorité',
		]);
    }

    public function store(PrioriteStoreRequest $request)
    {
        $priorite = Priorite::create($request->validated());

        return redirect()->route('priorites.index')->with('success', 'période créée avec succès');
       
    }

    public function show(Request $request, Priorite $priorite)
    {
        return view('priorite.show', [
            'priorite' => $priorite,
			'breadcrumb' => 'Reférentiel > Priorités',
        ]);
    }

    public function edit(Request $request, Priorite $priorite)
    {
        return view('priorite.edit', [
            'priorite' => $priorite,
			'breadcrumb' => 'Reférentiel > Mise à jour priorité',
        ]);
    }

    public function update(PrioriteUpdateRequest $request, Priorite $priorite)
    {
        $priorite->update($request->validated());

        return redirect()->route('priorites.index')->with('success', 'période modifiée avec succès');
    }

    public function destroy(Request $request, Priorite $priorite)
    {
        $priorite->delete();

        return redirect()->route('priorites.index')->with('success', 'période supprimée avec succès');
    }
}
