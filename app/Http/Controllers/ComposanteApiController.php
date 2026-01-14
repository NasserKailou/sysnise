<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComposanteStoreRequest;
use App\Http\Requests\ComposanteUpdateRequest;
use App\Http\Resources\ComposanteCollection;
use App\Http\Resources\ComposanteResource;
use App\Models\Composante;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComposanteApiController extends Controller
{
    public function index(Request $request)
    {
        $composantes = Composante::all();
		return response()->json($composantes);
    }

    public function store(ComposanteStoreRequest $request)
    {
		$composante = new Composante();
		$composante->intitule = $request->intitule;
		$composante->projet_id = $request->projet_id;
			
		if($request->composante_id > 0)
			$composante->composante_id = $request->composante_id;
		$composante->save();
			
		return $composante->id;

    }

    public function show(Request $request, Composante $composante)
    {
        return response()->json($composante);
    }

    public function update(ComposanteUpdateRequest $request, Composante $composante)
    {
        $composante = Composante::find($request->id);
		$composante->intitule = $request->intitule;
		if($request->composante_id != null) 
			$composante->composante_id = $request->composante_id;
		$composante->save();
		return $composante->id;
        
    }

    public function destroy(Request $request, Composante $composante)
    {
        $composante->delete();

        return response()->noContent();
    }
}
