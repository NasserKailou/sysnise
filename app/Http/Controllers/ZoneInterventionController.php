<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesagregationStoreRequest;
use App\Http\Requests\DesagregationUpdateRequest;
use App\Models\ZoneIntervention;
use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ZoneInterventionController extends Controller
{
    public function index(Request $request)
    {
        $zoneInterventions = ZoneIntervention::all();
		$zones = Zones::all();

        return view('zoneIntervention.index', [
            'zoneInterventions' => $zoneInterventions,
			'zones' => $zones,
        ]);
    }

    public function create(Request $request)
    {
        return view('populationCibleProjet.create');
    }

    /*public function store(DesagregationStoreRequest $request)
    {
        $desagregation = Desagregation::create($request->validated());

        return redirect()->route('desagregations.index')->with('success', 'désagrégation créée avec succès');

    }

    public function show(Request $request, Desagregation $desagregation)
    {
        return view('desagregation.show', [
            'desagregation' => $desagregation,
        ]);
    }

    public function edit(Request $request, Desagregation $desagregation)
    {
		$typeDesagregations = TypeDesagregation::all();
        return view('desagregation.edit', [
            'desagregation' => $desagregation,
			'typeDesagregations' => $typeDesagregations,
        ]);
    }

    public function update(DesagregationUpdateRequest $request, Desagregation $desagregation)
    {
        $desagregation->update($request->validated());

        return redirect()->route('desagregations.index')->with('success', 'désagrégation modifiée avec succès');
    }

    public function destroy(Request $request, Desagregation $desagregation)
    {
        $desagregation->delete();

        return redirect()->route('desagregations.index')->with('success', 'désagrégation supprimée avec succès');
    }*/
}
