<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProduitStoreRequest;
use App\Http\Requests\ProduitUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\StatutProduit;
use App\Models\TypeProduit;
use App\Models\PieceJointeActivite;
use App\Models\Zone;
use App\Models\CadreLogique;
use Illuminate\View\View;


class ProduitController extends Controller
{
    public function index($cadre_logique_id)
    {
		$cadre_logique = CadreLogique::findOrFail($cadre_logique_id);
		$produits = Produit::where('cadre_logique_id', $cadre_logique_id)->get();
		$statutProduits = StatutProduit::all();
		$typeProduits = TypeProduit::all();
		$zones = Zone::all();
		$breadcrumb = 'Projet > Produits';
        return view('produit.index',compact('breadcrumb','cadre_logique','produits','statutProduits','typeProduits','zones'));
    
	}
	
	public function store(ProduitStoreRequest $request,$cadre_logique_id)
    {
		 // Récupère les données validées
        $data = $request->validated();
		$data['cadre_logique_id'] = $cadre_logique_id;
		$produit = Produit::create($data);
		
		//Récupérer les IDs de zones envoyés depuis la vue
		$zoneIds = array_filter(explode(',', $request->input('zone_ids', '')));
		$produit->zones()->attach($zoneIds);

        return redirect()
			->route('cadre_logiques.produits.index', $cadre_logique_id)
			->with('success', 'Produit enregistré avec succès.');
	
    }
	
	public function show(Request $request, CadreLogique $cadre_logique, Produit $produit)
    {
		$zonesProduit = $produit->zones->pluck('intitule')->implode(', ');
        $breadcrumb = 'Projet > Produits';
		return view('produit.show', compact('breadcrumb','cadre_logique', 'produit','zonesProduit'));
    }
	
	public function edit(CadreLogique $cadre_logique, Produit $produit)
    {
		$statutProduits = StatutProduit::all();
		$typeProduits = TypeProduit::all();
		$zones = Zone::all();
		// Récupérer les intitulés des zones liées au produit
		$zoneNames = $produit->zones->pluck('intitule')->implode(', ');

		// Tu peux aussi récupérer les IDs si besoin
		$zoneIds = $produit->zones->pluck('id')->implode(',');
		$breadcrumb = 'Projet > Mise à jour Produit';
		return view('produit.edit', compact('breadcrumb','cadre_logique', 'produit','statutProduits','typeProduits','zones','zoneNames','zoneIds'));
    }
	
    public function update(ProduitStoreRequest $request, $cadre_logique_id, Produit $produit)
    {
        $data = $request->validated();
        $produit->update($data);
		
		//Récupérer les IDs de zones envoyés depuis la vue
		$zoneIds = array_filter(explode(',', $request->input('zone_ids', '')));

		//attach() : Ajoute les nouvelles, peut provoquer des doublons
		//sync() : Remplace complètement les anciennes associations
		//syncWithoutDetaching() : Ajoute les nouvelles, garde les anciennes (pas de doublons)
		
		//Synchroniser les zones sans créer de doublons
		$produit->zones()->sync($zoneIds);

        return redirect()
            ->route('cadre_logiques.produits.index', $cadre_logique_id)
            ->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Request $request, Produit $produit)
    {
        $produit->delete();
		
		return redirect()
			->route('cadre_logiques.produits.index', $produit.cadre_logique_id)
			->with('success', 'Produit supprimé avec succès.');
	
   }
	
}
