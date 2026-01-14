<?php

namespace App\Http\Controllers;
use App\Http\Requests\HypotheseRisqueStoreRequest;
use App\Http\Requests\HypotheseRisqueUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\HypotheseRisque;
use App\Models\CadreLogique;
use Illuminate\View\View;


class HypotheseRisqueController extends Controller
{
    public function index($cadre_logique_id)
    {
		$cadre_logique = CadreLogique::findOrFail($cadre_logique_id);
		$hypotheses_risques = HypotheseRisque::where('cadre_logique_id', $cadre_logique_id)->get();
        $breadcrumb = 'Cadres stratégiques > Hypothèse et Risque',
		return view('hypothese_risque.index',compact('breadcrumb','cadre_logique','hypotheses_risques'));
    
	}
	
	public function store(HypotheseRisqueStoreRequest $request,$cadre_logique_id)
    {
		 // Récupère les données validées
        $data = $request->validated();
		$data['cadre_logique_id'] = $cadre_logique_id;
		HypotheseRisque::create($data);
	
        // Redirection vers la bonne route (probablement 'cadre_logiques.hypothese_risques.index')
		return redirect()
			->route('cadre_logiques.hypothese_risques.index', $cadre_logique_id)
			->with('success', 'Hypothèse et risque enregistrés avec succès.');
	
    }
	
	public function edit(CadreLogique $cadre_logique, HypotheseRisque $hypothese_risque)
    {
		$breadcrumb = 'Cadres stratégiques > Mise à jour Hypothèse et Risque',
		return view('hypothese_risque.edit', compact('breadcrumb','cadre_logique', 'hypothese_risque'));
    }

    public function update(HypotheseRisqueStoreRequest $request, $cadre_logique_id, HypotheseRisque $hypothese_risque)
    {
        $data = $request->validated();
        $hypothese_risque->update($data);

        return redirect()
            ->route('cadre_logiques.hypothese_risques.index', $cadre_logique_id)
            ->with('success', 'Hypothèse et risque mis à jour avec succès.');
    }

    public function destroy(Request $request, HypotheseRisque $hypotheses_risque)
    {
        $hypotheses_risque->delete();
		
		return redirect()
			->route('cadre_logiques.hypothese_risques.index', $hypotheses_risque.cadre_logique_id)
			->with('success', 'Hypothèse et risque supprimés avec succès.');
	
   }
	
}
