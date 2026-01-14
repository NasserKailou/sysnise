<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstitutionTutelleStoreRequest;
use App\Http\Requests\InstitutionTutelleUpdateRequest;
use App\Models\InstitutionTutelle;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstitutionTutelleController extends Controller
{
    public function index(Request $request)
    {
        $institutionTutelles = InstitutionTutelle::whereNull('deleted_on')->get();

        return view('institutionTutelle.index', [
            'institutionTutelles' => $institutionTutelles,
			'breadcrumb' => 'Reférentiel > Institutions tutelles',
        ]);
    }

    public function create(Request $request)
    {
        return view('institutionTutelle.create',[
		'breadcrumb' => 'Reférentiel > Nouvelle Institution Tutelle',
		]);
    }

    public function store(InstitutionTutelleStoreRequest $request)
    {
        $institutionTutelle = InstitutionTutelle::create($request->validated());

        return redirect()->route('institution_tutelles.index')->with('success', 'niveau de financement créée avec succès');
       
    }

    public function show(Request $request, InstitutionTutelle $institutionTutelle)
    {
        return view('institutionTutelle.show', [
            'institutionTutelle' => $institutionTutelle,
			'breadcrumb' => 'Reférentiel > Institutions tutelles',
        ]);
    }

    public function edit(Request $request, InstitutionTutelle $institutionTutelle)
    {
        return view('institutionTutelle.edit', [
            'institutionTutelle' => $institutionTutelle,
			'breadcrumb' => 'Reférentiel > Mise à jour institution tutelle',
        ]);
    }

    public function update(InstitutionTutelleUpdateRequest $request, InstitutionTutelle $institutionTutelle)
    {
        $institutionTutelle->update($request->validated());

        return redirect()->route('institution_tutelles.index')->with('success', 'niveau de financement modifiée avec succès');
    }

    public function destroy(Request $request, InstitutionTutelle $institutionTutelle)
    {
       $institutionTutelle->deleted_on = Carbon::now();
          $institutionTutelle->save();

        return redirect()->route('institution_tutelles.index')->with('success', 'niveau de financement supprimée avec succès');
    }
}
