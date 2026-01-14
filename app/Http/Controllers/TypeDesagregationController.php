<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeDesagregationStoreRequest;
use App\Http\Requests\TypeDesagregationUpdateRequest;
use App\Models\TypeDesagregation;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TypeDesagregationController extends Controller
{
       public function index(Request $request)
    {
        $typeDesagregations = TypeDesagregation::whereNull('deleted_on')->get();

        return view('typeDesagregation.index', [
            'typeDesagregations' => $typeDesagregations,
			'breadcrumb' => 'Reférentiel > Types Désagrégation',
        ]);
    }

    public function create(Request $request)
    {
        return view('typeDesagregation.create',[
			'breadcrumb' => 'Reférentiel > Nouveau Type Désagrégation',
		]);
    }

    public function store(TypeDesagregationStoreRequest $request)
    {
        $typeDesagregation = TypeDesagregation::create($request->validated());

        return redirect()->route('type_desagregations.index')->with('success', 'type désagrégation créé avec succès');
    }

    public function show(Request $request, TypeDesagregation $typeDesagregation)
    {
        return view('typeDesagregation.show', [
            'typeDesagregation' => $typeDesagregation,
			'breadcrumb' => 'Reférentiel > Type Désagrégation',
        ]);
    }

    public function edit(Request $request, TypeDesagregation $typeDesagregation)
    {
        return view('typeDesagregation.edit', [
            'typeDesagregation' => $typeDesagregation,
			'breadcrumb' => 'Reférentiel > Mise à jour Type Désagrégation',
        ]);
    }

    public function update(TypeDesagregationUpdateRequest $request, TypeDesagregation $typeDesagregation)
    {
        $typeDesagregation->update($request->validated());

        return redirect()->route('type_desagregations.index')->with('success', 'type désagrégation modifié avec succès');
    }

    public function destroy(Request $request, TypeDesagregation $typeDesagregation)
    {
        $typeDesagregation->deleted_on = Carbon::now();
          $typeDesagregation->save();

        return redirect()->route('type_desagregations.index')->with('success', 'type désagrégation supprimé avec succès');
    }
}
