<?php

namespace App\Http\Controllers;

//use App\Http\Requests\ComposanteIndicateurStoreRequest;
//use App\Http\Requests\ComposanteIndicateurUpdateRequest;
//use App\Http\Resources\ComposanteIndicateurCollection;
use App\Http\Resources\ComposanteIndicateurResource;
use App\Models\ComposanteIndicateur;
use App\Models\Composante;
use App\Models\Indicateur;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComposanteIndicateurApiController extends Controller
{
   public function index(Request $request)
    {
        $ComposanteIndicateurs = ComposanteIndicateur::all();
		return response()->json($ComposanteIndicateurs);
    }
	//ComposanteIndicateurStoreRequest $request
    public function store(Request $request)
    {
		$ComposanteIndicateur = new ComposanteIndicateur();
		$ComposanteIndicateur->indicateur_id = $request->indicateur_id;
		$ComposanteIndicateur->composante_id = $request->composante_id;
		$ComposanteIndicateur->save();
		
		//return $ComposanteIndicateur;
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
			if (isset($assoc['composante_id'], $assoc['indicateur_id'])) {
				$insertData[] = [
					'composante_id' => $assoc['composante_id'],
					'indicateur_id' => $assoc['indicateur_id'],
					'created_at' => now(),
					'updated_at' => now()
				];
			}
		}

		if (!empty($insertData)) {
			ComposanteIndicateur::insert($insertData);
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
			if (isset($assoc['composante_id'], $assoc['indicateur_id'])) {
				$deleted = ComposanteIndicateur::where('composante_id', $assoc['composante_id'])
					->where('indicateur_id', $assoc['indicateur_id'])
					->delete(); // delete sur QueryBuilder
				$deletedCount += $deleted;
			}
		}

		return response()->json([
			'message' => "$deletedCount association(s) supprimée(s) avec succès"
		]);
	}


    public function show(Request $request, ComposanteIndicateur $ComposanteIndicateur)
    {
        return response()->json($ComposanteIndicateur);
    }

    public function destroy(Request $request, ComposanteIndicateur $ComposanteIndicateur,Indicateur $Indicateur)
    {
        $ComposanteIndicateur = ComposanteIndicateur::where('composante_id', $request->composante_id)
        ->where('indicateur_id', $request->indicateur_id)
        ->first();
		
		$ComposanteIndicateur->delete();

        return response()->noContent();
    }
	
	public function getIndicateursByComposante($composante_id)
	{
		// Indicateurs déjà associés à la composante (type_indicateur_id = 2)
		$selectedIndicators = ComposanteIndicateur::where('composante_id', $composante_id)
			->whereHas('indicateur', function ($query) {
				$query->where('type_indicateur_id', 2);
			})
			->with(['indicateur' => function ($query) {
				$query->select('id', 'intitule', 'type_indicateur_id');
			}])
			->get()
			->pluck('indicateur');

		// Indicateurs NON associés à la composante (type_indicateur_id = 2)
		$notSelectedIndicators = Indicateur::where('type_indicateur_id', 2)
			->whereDoesntHave('composanteIndicateurs', function ($query) use ($composante_id) {
				$query->where('composante_id', $composante_id);
			})
			->select('id', 'intitule')
			->get();

		return response()->json([
			'selected'    => $selectedIndicators,
			'notSelected' => $notSelectedIndicators
		]);
	}
	public function getIndicateursInComposante($composante_id)
	{
		$indicateurs = ComposanteIndicateur::where('composante_id', $composante_id)
			->whereHas('indicateur', function ($query) {
				$query->where('type_indicateur_id', 2);
			})
			->with(['indicateur' => function ($query) {
				$query->select('id', 'intitule', 'type_indicateur_id');
			}])
			->get()
			->pluck('indicateur');

		return response()->json($indicateurs);
	}
	public function getIndicateursNotInComposante($composante_id)
	{
		$indicateurs = Indicateur::where('type_indicateur_id', 2)
			->whereDoesntHave('composanteIndicateurs', function ($query) use ($composante_id) {
				$query->where('composante_id', $composante_id);
			})
			->select('id', 'intitule')
			->get();

		return response()->json($indicateurs);
	}



	/*public function getIndicateursByComposante($composante_id)
    {
        $selectedIndicators = ComposanteIndicateur::where('composante_id', $composante_id)
            ->with('indicateur:id,intitule') // on récupère seulement id et name
            ->get()
            ->pluck('indicateur');
			
		$notSelectedIndicators = Indicateur::whereDoesntHave('composanteIndicateurs', function($query) use ($composante_id) {
			$query->where('composante_id', $composante_id);
		})
		->select('id', 'intitule') // récupérer seulement id et intitule
		->get();

        return response()->json(['selected' => $selectedIndicators,'notSelected' => $notSelectedIndicators]);
    }*/
	
	/*public function getIndicateursInComposante($composante_id)
    {
        $indicateurs = ComposanteIndicateur::where('composante_id', $composante_id)
            ->with('indicateur:id,intitule') // on récupère seulement id et name
            ->get()
            ->pluck('indicateur');

        return response()->json($indicateurs);
    }*/
	
	/*public function getIndicateursNotInComposante($composante_id)
	{
		$indicateurs = Indicateur::whereDoesntHave('composanteIndicateurs', function($query) use ($composante_id) {
			$query->where('composante_id', $composante_id);
		})
		->select('id', 'intitule') // récupérer seulement id et intitule
		->get();

		return response()->json($indicateurs);
	}*/
}
