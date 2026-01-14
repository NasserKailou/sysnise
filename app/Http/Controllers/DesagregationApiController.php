<?php

namespace App\Http\Controllers;

/*use App\Http\Requests\DesagregationStoreRequest;
use App\Http\Requests\DesagregationUpdateRequest;
use App\Http\Resources\DesagregationCollection;
use App\Http\Resources\DesagregationResource;*/
use App\Models\Desagregation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DesagregationApiController extends Controller
{
	public function index(Request $request)
    {
        $Desagregations = Desagregation::all();
		return response()->json($Desagregations);
    }

    public function store(Request $request)
    {
		$Desagregation = new Desagregation();
		$Desagregation->intitule = $request->intitule;
		$Desagregation->type_desagregation_id = $request->type_desagregation_id;
		$Desagregation->save();
		
		return $Desagregation->id;

    }

    public function show(Request $request, Desagregation $Desagregation)
    {
        return response()->json($Desagregation);
    }

    public function update(Request $request, Desagregation $Desagregation)
    {
        $Desagregation = Desagregation::find($request->id);
		$Desagregation->intitule = $request->intitule;
		$Desagregation->save();
		return $Desagregation->id;
        
    }

    public function destroy(Request $request, Desagregation $Desagregation)
    {
        $Desagregation->delete();

        return response()->noContent();
    }
}
