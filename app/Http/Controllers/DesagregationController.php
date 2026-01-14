<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesagregationStoreRequest;
use App\Http\Requests\DesagregationUpdateRequest;
use App\Models\Desagregation;
use App\Models\TypeDesagregation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DesagregationController extends Controller
{
    public function index(Request $request)
    {
        $desagregations = Desagregation::all();
		$typeDesagregations = TypeDesagregation::all();

        return view('desagregation.index', [
            'desagregations' => $desagregations,
			'typeDesagregations' => $typeDesagregations,
			'breadcrumb' => 'Reférentiel > Désagrégations',
		]);
    }

    public function create(Request $request)
    {
        return view('desagregation.create',[
			'breadcrumb' => 'Reférentiel > Nouvelle Désagrégation',
		]);
		
    }

    public function store(DesagregationStoreRequest $request)
    {
        $desagregation = Desagregation::create($request->validated());

        return redirect()->route('desagregations.index')->with('success', 'désagrégation créée avec succès');

    }

    public function show(Request $request, Desagregation $desagregation)
    {
        return view('desagregation.show', [
            'desagregation' => $desagregation,
			'breadcrumb' => 'Reférentiel > Désagrégations',
        ]);
    }

    public function edit(Request $request, Desagregation $desagregation)
    {
		$typeDesagregations = TypeDesagregation::all();
        return view('desagregation.edit', [
            'desagregation' => $desagregation,
			'typeDesagregations' => $typeDesagregations,
			'breadcrumb' => 'Reférentiel > Mise à jour Désagrégation',
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
    }
}
