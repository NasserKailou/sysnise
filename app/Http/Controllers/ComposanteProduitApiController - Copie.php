<?php

namespace App\Http\Controllers;

use App\Http\Resources\ComposanteProduitResource;
use App\Models\ComposanteProduit;
use App\Models\Composante;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComposanteProduitApiController extends Controller
{
   public function index(Request $request)
    {
        $ComposanteProduits = ComposanteProduit::all();
		return response()->json($ComposanteProduits);
    }
	//ComposanteProduitStoreRequest $request
    public function store(Request $request)
    {
		$ComposanteProduit = new ComposanteProduit();
		$ComposanteProduit->produit_id = $request->produit_id;
		$ComposanteProduit->composante_id = $request->composante_id;
		$ComposanteProduit->save();
		
		//return $ComposanteProduit;
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
			if (isset($assoc['composante_id'], $assoc['produit_id'])) {
				$insertData[] = [
					'composante_id' => $assoc['composante_id'],
					'produit_id' => $assoc['produit_id'],
					'created_at' => now(),
					'updated_at' => now()
				];
			}
		}

		if (!empty($insertData)) {
			ComposanteProduit::insert($insertData);
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
			if (isset($assoc['composante_id'], $assoc['produit_id'])) {
				$deleted = ComposanteProduit::where('composante_id', $assoc['composante_id'])
					->where('produit_id', $assoc['produit_id'])
					->delete(); // delete sur QueryBuilder
				$deletedCount += $deleted;
			}
		}

		return response()->json([
			'message' => "$deletedCount association(s) supprimée(s) avec succès"
		]);
	}


    public function show(Request $request, ComposanteProduit $ComposanteProduit)
    {
        return response()->json($ComposanteProduit);
    }

    public function destroy(Request $request, ComposanteProduit $ComposanteProduit,Produit $Produit)
    {
        $ComposanteProduit = ComposanteProduit::where('composante_id', $request->composante_id)
        ->where('produit_id', $request->produit_id)
        ->first();
		
		$ComposanteProduit->delete();

        return response()->noContent();
    }
	
	public function getProduitsByComposante($composante_id)
	{
		// Produits déjà associés à la composante (type_produit_id = 2)
		$selectedIndicators = ComposanteProduit::where('composante_id', $composante_id)
			->whereHas('produit', function ($query) {
				$query->where('type_produit_id', 2);
			})
			->with(['produit' => function ($query) {
				$query->select('id', 'intitule', 'type_produit_id');
			}])
			->get()
			->pluck('produit');

		// Produits NON associés à la composante (type_produit_id = 2)
		$notSelectedIndicators = Produit::where('type_produit_id', 2)
			->whereDoesntHave('composanteProduits', function ($query) use ($composante_id) {
				$query->where('composante_id', $composante_id);
			})
			->select('id', 'intitule')
			->get();

		return response()->json([
			'selected'    => $selectedIndicators,
			'notSelected' => $notSelectedIndicators
		]);
	}
	public function getProduitsInComposante($composante_id)
	{
		$produits = ComposanteProduit::where('composante_id', $composante_id)
			->whereHas('produit', function ($query) {
				$query->where('type_produit_id', 2);
			})
			->with(['produit' => function ($query) {
				$query->select('id', 'intitule', 'type_produit_id');
			}])
			->get()
			->pluck('produit');

		return response()->json($produits);
	}
	public function getProduitsNotInComposante($composante_id)
	{
		$produits = Produit::where('type_produit_id', 2)
			->whereDoesntHave('composanteProduits', function ($query) use ($composante_id) {
				$query->where('composante_id', $composante_id);
			})
			->select('id', 'intitule')
			->get();

		return response()->json($produits);
	}

}
