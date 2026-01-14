<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadreMesureResultatStoreRequest;
use App\Http\Requests\CadreMesureResultatUpdateRequest;
use App\Http\Resources\CadreMesureResultatCollection;
use App\Http\Resources\CadreMesureResultatResource;
use App\Models\CadreMesureResultat;
use App\Models\CadreLogique;
use App\Models\Indicateur;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CadreMesureResultatApiController extends Controller
{
   public function index(Request $request)
    {
        $CadreMesureResultats = CadreMesureResultat::all();
		return response()->json($CadreMesureResultats);
    }
	//CadreMesureResultatStoreRequest $request
    public function store(Request $request)
    {
		$CadreMesureResultat = new CadreMesureResultat();
		$CadreMesureResultat->indicateur_id = $request->indicateur_id;
		$CadreMesureResultat->cadre_logique_id = $request->cadre_logique_id;
		$CadreMesureResultat->save();
		
		//return $CadreMesureResultat;
		return response()->noContent();

    }
	
	public function storeBatch(Request $request)
	{
		$data = $request->input('associations', []);

		if (empty($data)) {
			return response()->json(['message' => 'Aucune donnée envoyée'], 400);
		}

		$insertData = [];

		foreach ($data as $assoc) {
			if (isset($assoc['cadre_logique_id'], $assoc['indicateur_id'])) {
				$insertData[] = [
					'cadre_logique_id' => $assoc['cadre_logique_id'],
					'indicateur_id' => $assoc['indicateur_id'],
					'created_at' => now(),
					'updated_at' => now()
				];
			}
		}

		if (!empty($insertData)) {
			CadreMesureResultat::insert($insertData);
		}

		return response()->json(['message' => 'Associations insérées avec succès']);
	}
	
	public function deleteBatch(Request $request)
	{
		$data = $request->input('associations', []);

		if (empty($data)) {
			return response()->json(['message' => 'Aucune donnée envoyée'], 400);
		}

		$deletedCount = 0;

		foreach ($data as $assoc) {
			if (isset($assoc['cadre_logique_id'], $assoc['indicateur_id'])) {
				$deleted = CadreMesureResultat::where('cadre_logique_id', $assoc['cadre_logique_id'])
					->where('indicateur_id', $assoc['indicateur_id'])
					->delete(); // delete sur QueryBuilder
				$deletedCount += $deleted;
			}
		}

		return response()->json([
			'message' => "$deletedCount association(s) supprimée(s) avec succès"
		]);
	}


    public function show(Request $request, CadreMesureResultat $CadreMesureResultat)
    {
        return response()->json($CadreMesureResultat);
    }

    public function destroy(Request $request, CadreMesureResultat $CadreMesureResultat,Indicateur $Indicateur)
    {
        $CadreMesureResultat = CadreMesureResultat::where('cadre_logique_id', $request->cadre_logique_id)
        ->where('indicateur_id', $request->indicateur_id)
        ->first();
		
		$CadreMesureResultat->delete();

        return response()->noContent();
    }
	
	public function getIndicateursByCadreLogique($cadre_logique_id)
    {
        $selectedIndicators = CadreMesureResultat::where('cadre_logique_id', $cadre_logique_id)
            ->with('indicateur:id,intitule') // on récupère seulement id et name
            ->get()
            ->pluck('indicateur');
			
		$notSelectedIndicators = Indicateur::whereDoesntHave('cadreMesureResultats', function($query) use ($cadre_logique_id) {
			$query->where('cadre_logique_id', $cadre_logique_id);
		})
		->select('id', 'intitule') // récupérer seulement id et intitule
		->get();

        return response()->json(['selected' => $selectedIndicators,'notSelected' => $notSelectedIndicators]);
    }
	
	public function getIndicateursInCadreLogique($cadre_logique_id)
    {
        $indicateurs = CadreMesureResultat::where('cadre_logique_id', $cadre_logique_id)
            ->with('indicateur:id,intitule') // on récupère seulement id et name
            ->get()
            ->pluck('indicateur');

        return response()->json($indicateurs);
    }
	
	public function getIndicateursNotInCadreLogique($cadre_logique_id)
	{
		$indicateurs = Indicateur::whereDoesntHave('cadreMesureResultats', function($query) use ($cadre_logique_id) {
			$query->where('cadre_logique_id', $cadre_logique_id);
		})
		->select('id', 'intitule') // récupérer seulement id et intitule
		->get();

		return response()->json($indicateurs);
	}
}
