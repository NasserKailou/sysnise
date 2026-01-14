<?php

namespace App\Http\Controllers;

use App\Models\TypeDesagregation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TypeDesagregationApiController extends Controller
{
	public function index(Request $request)
    {
        $TypeDesagregations = TypeDesagregation::all();
		return response()->json($TypeDesagregations);
    }

    public function store(Request $request)
    {
		$TypeDesagregation = new TypeDesagregation();
		$TypeDesagregation->intitule = $request->intitule;
		$TypeDesagregation->save();
		
		return $TypeDesagregation->id;

    }

    public function show(Request $request, TypeDesagregation $TypeDesagregation)
    {
        return response()->json($TypeDesagregation);
    }

    public function update(Request $request, TypeDesagregation $TypeDesagregation)
    {
        $TypeDesagregation = TypeDesagregation::find($request->id);
		$TypeDesagregation->intitule = $request->intitule;
		$TypeDesagregation->save();
		return $TypeDesagregation->id;
        
    }

    public function destroy(Request $request, TypeDesagregation $TypeDesagregation)
    {
        $TypeDesagregation->delete();

        return response()->noContent();
    }
}
