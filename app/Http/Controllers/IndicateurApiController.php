<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndicateurStoreRequest;
use App\Http\Requests\IndicateurUpdateRequest;
use App\Http\Resources\IndicateurCollection;
use App\Http\Resources\IndicateurResource;
use App\Models\Indicateur;
use App\Models\Desagregation;
use App\Models\OrientationCadreDeveloppement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndicateurApiController extends Controller
{
    //public function index()
	public function index(Request $request)
    {
        $Indicateurs = Indicateur::all();
		return response()->json($Indicateurs);
    }

    public function store(IndicateurStoreRequest $request)
    {
		$Indicateur = new Indicateur();
		$Indicateur->intitule = $request->intitule;
		if($request->type_indicateur_id != null)
			$Indicateur->type_indicateur_id = $request->type_indicateur_id;	
		$Indicateur->save();
		
		return $Indicateur->id;

    }

    public function show(Request $request, Indicateur $Indicateur)
    {
        return response()->json($Indicateur);
    }

    public function update(IndicateurUpdateRequest $request, Indicateur $Indicateur)
    {
        $Indicateur = Indicateur::find($request->id);
		$Indicateur->intitule = $request->intitule;
		if($request->type_indicateur_id != null)
			$Indicateur->type_indicateur_id = $request->type_indicateur_id;	
		$Indicateur->save();
		return $Indicateur->id;
        
    }

    public function destroy(Request $request, Indicateur $Indicateur)
    {
        $Indicateur->delete();

        return response()->noContent();
    }
	
	public function getDesagregationsByIndicateur(Request $request, $indicateurId, $typeDesagregationId)
	{
		$indicateur = Indicateur::findOrFail($indicateurId);

		// Désagrégations associées filtrées par type
		$selectedDesagregations = $indicateur->desagregations()->where('desagregations.type_desagregation_id', $typeDesagregationId)->select('desagregations.id', 'desagregations.intitule')->get();

		// Désagrégations non associées filtrées par type
		$notSelectedDesagregations = Desagregation::where('type_desagregation_id', $typeDesagregationId)->whereDoesntHave('indicateurs', function($q) use ($indicateurId) {
				$q->where('indicateur_id', $indicateurId);
			})->select('id', 'intitule')->get();

		return response()->json([
			'selected' => $selectedDesagregations,
			'notSelected' => $notSelectedDesagregations
		]);
	}

}
