<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadreLogiqueStoreRequest;
use App\Http\Requests\CadreLogiqueUpdateRequest;
use App\Http\Resources\CadreLogiqueCollection;
use App\Http\Resources\CadreLogiqueResource;
use App\Models\CadreLogique;
use App\Models\OrientationCadreDeveloppement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CadreLogiqueApiController extends Controller
{
    public function index(Request $request)
    {
        $cadreLogiques = CadreLogique::all();
		return response()->json($cadreLogiques);
    }

    public function store(CadreLogiqueStoreRequest $request)
    {
		if($request->cadre_logique_id > 0)
		{
			$cadreLogique = new CadreLogique();
			$cadreLogique->intitule = $request->intitule;
			$cadreLogique->cadre_logique_id = $request->cadre_logique_id;
			$cadreLogique->save();
		}
		else
		{
			$cadreLogique = new CadreLogique();
			$cadreLogique->intitule = $request->intitule;
			$cadreLogique->save();
			$orientationCadreDeveloppement = new OrientationCadreDeveloppement();
			$orientationCadreDeveloppement->cadre_developpement_id = $request->cadre_developpement_id;
			$orientationCadreDeveloppement->cadre_logique_id = $cadreLogique->id;
			$orientationCadreDeveloppement->intitule = $cadreLogique->intitule;
			$orientationCadreDeveloppement->save();
			
		}
			
		return $cadreLogique->id;

    }

    public function show(Request $request, CadreLogique $cadreLogique)
    {
        return response()->json($cadreLogique);
    }

    public function update(CadreLogiqueUpdateRequest $request, CadreLogique $cadreLogique)
    {
        $cadreLogique = CadreLogique::find($request->id);
		$cadreLogique->intitule = $request->intitule;
		if($request->cadre_logique_id != null) 
			$cadreLogique->cadre_logique_id = $request->cadre_logique_id;
		$cadreLogique->save();
		return $cadreLogique->id;
        
    }

    public function destroy(Request $request, CadreLogique $cadreLogique)
    {
        $cadreLogique->delete();

        return response()->noContent();
    }
}
