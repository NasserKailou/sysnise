<?php

namespace App\Http\Controllers;
use App\Http\Requests\ActiviteStoreRequest;
use App\Http\Requests\ActiviteUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Activite;
use App\Models\Zone;
use App\Models\StatutActivite;
use App\Models\TypeActivite;
use App\Models\PieceJointeActivite;
use App\Models\CadreLogique;
use Illuminate\View\View;


class ActiviteController extends Controller
{
    public function index($cadre_logique_id)
    {
		$cadre_logique = CadreLogique::findOrFail($cadre_logique_id);
		$activites = Activite::where('cadre_logique_id', $cadre_logique_id)->get();
		$statutActivites = StatutActivite::all();
		$typeActivites = TypeActivite::all();
		$zones = Zone::all();
        return view('activite.index', [
			'breadcrumb'	=> 'Projet > Activité',
			'cadre_logique'	=> $cadre_logique, 
			'activites'    	=> $activites,
			'statutActivites'	=> $statutActivites, 
			'typeActivites'	=> $typeActivites,
			'zones'       	=> $zones,
		]);
    
	}
	
	public function store(ActiviteStoreRequest $request,$cadre_logique_id)
    {
		 // Récupère les données validées
        $data = $request->validated();
		$data['cadre_logique_id'] = $cadre_logique_id;
		$activite = Activite::create($data);
		
		//Récupérer les IDs de zones envoyés depuis la vue
		$zoneIds = array_filter(explode(',', $request->input('zone_ids', '')));
		$activite->zones()->attach($zoneIds);
	
        // Redirection vers la bonne route (probablement 'cadre_logiques.activites.index')
		return redirect()
			->route('cadre_logiques.activites.index', $cadre_logique_id)
			->with('success', 'Activite enregistré avec succès.');
	
    }
	
	public function show(Request $request, CadreLogique $cadre_logique, Activite $activite)
    {
		$breadcrumb = 'Projet > Activité';
		$zonesActivite = $activite->zones->pluck('intitule')->implode(', ');
        return view('activite.show', compact('breadcrumb','cadre_logique', 'activite','zonesActivite'));
    }
	
	public function edit(CadreLogique $cadre_logique, Activite $activite)
    {
		$breadcrumb = 'Projet > Activité';
		$activites = Activite::where('cadre_logique_id', $cadre_logique->id)->get();
		$statutActivites = StatutActivite::all();
		$typeActivites = TypeActivite::all();
		
		$zones = Zone::all();
		// Récupérer les intitulés des zones liées au produit
		$zoneNames = $activite->zones->pluck('intitule')->implode(', ');

		// Tu peux aussi récupérer les IDs si besoin
		$zoneIds = $activite->zones->pluck('id')->implode(',');
		
		return view('activite.edit', compact('breadcrumb','cadre_logique', 'activite','statutActivites','typeActivites','activites','zones','zoneNames','zoneIds'));
    }
	
    public function update(ActiviteStoreRequest $request, $cadre_logique_id, Activite $activite)
    {
        $data = $request->validated();
        $activite->update($data);
		
		//Récupérer les IDs de zones envoyés depuis la vue
		$zoneIds = array_filter(explode(',', $request->input('zone_ids', '')));

		//attach() : Ajoute les nouvelles, peut provoquer des doublons
		//sync() : Remplace complètement les anciennes associations
		//syncWithoutDetaching() : Ajoute les nouvelles, garde les anciennes (pas de doublons)
		
		//Synchroniser les zones sans créer de doublons
		$activite->zones()->sync($zoneIds);

        return redirect()
            ->route('cadre_logiques.activites.index', $cadre_logique_id)
            ->with('success', 'Activite mis à jour avec succès.');
    }

    public function destroy(Request $request, Activite $activite)
    {
        $activite->delete();
		
		return redirect()
			->route('cadre_logiques.activites.index', $activite.cadre_logique_id)
			->with('success', 'Activite supprimé avec succès.');
	
   }
	
}
