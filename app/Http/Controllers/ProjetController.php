<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjetUserRequest;
use App\Models\ProjetUser;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CadreDeveloppementStoreRequest;
use App\Http\Requests\CadreDeveloppementUpdateRequest;
use App\Http\Requests\PopulationCibleProjetStoreRequest;
use App\Http\Requests\PopulationCibleProjetUpdateRequest;
use App\Models\CadreDeveloppement;
use App\Http\Requests\ProjetStoreRequest;
use App\Http\Requests\ProjetUpdateRequest;
use App\Models\CadreLogique;
use App\Models\EtudeDisponible;
use App\Models\EtudeEnvisagee;
use App\Models\RechercheFinancement;
use App\Models\Etude;
use App\Models\PieceJointeProjet;
use App\Models\Projet;
use App\Models\StatutProjet;
use App\Models\Zone;
use App\Models\Priorite;
use App\Models\Secteur;
use App\Models\PopulationCible;
use App\Models\InstitutionTutelle;
use App\Models\StatutFinancement;
use App\Models\CategorieDepense;
use App\Models\Composante;
use App\Models\Bailleur;
use App\Models\Devise;
use App\Models\NatureFinancement;
use App\Models\SourceFinancement;
use App\Models\PlanFinancement;
use App\Models\ClotureProjet;
use App\Models\BudgetAnnuelPrevu;
use App\Models\BudgetAnnuelDepense;
use App\Models\BudgetAnnuel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjetController extends Controller
{
    public function index(Request $request)
    {
        $projets = Projet::whereNull('deleted_on')
				//->where('user_id', auth()->id())
				->where('institution_tutelle_id', Auth::user()->institution_tutelle_id)
				->with(['projetUsers.userr']) // Charger les associations 
				->get();




$currentUserInstitutionId = Auth::user()->institution_tutelle_id;
             $users = User::where('institution_tutelle_id', '!=', $currentUserInstitutionId)
        //->whereNull('deleted_on')
        ->get();

        return view('projet.index', [
            'projets' => $projets,
			'breadcrumb' => 'Projets > Liste projets', 'users' =>$users
        ]);
    }

    public function create(Request $request)
    {
		$projets = Projet::whereNull('deleted_on')
				//->where('user_id', auth()->id())
				->where('institution_tutelle_id', Auth::user()->institution_tutelle_id)
				->get();
		$statutProjets = StatutProjet::whereNull('deleted_on')->get();
		$zones = Zone::whereNull('deleted_on')->get();
		$chaineLogiques = DB::table('view_cadre_logique')->get();
		
		$priorites = Priorite::all();
		$secteurs = Secteur::all();
		
        $populationCibles = PopulationCible::whereNull('deleted_on')->get();
		$institutionTutelles = InstitutionTutelle::whereNull('deleted_on')->get();
		$statutFinancements = StatutFinancement::whereNull('deleted_on')->get();
		$natureFinancements = NatureFinancement::whereNull('deleted_on')->get();
		$sourceFinancements = SourceFinancement::whereNull('deleted_on')->get();
		$devises = Devise::all();
		$instituion_tutelle_id=Auth::user()->institution_tutelle_id;
	

        return view('projet.create', [
            'projets' => $projets,
			'zones' => $zones,
			'devises' => $devises,
			'populationCibles' => $populationCibles,
			'institutionTutelles' => $institutionTutelles,
			'priorites' => $priorites,
			'secteurs' => $secteurs,
			'statutFinancements' => $statutFinancements,
			'natureFinancements' => $natureFinancements,
			'sourceFinancements' => $sourceFinancements,
			'chaineLogiques' => $chaineLogiques,
			'statutProjets' => $statutProjets,
			'breadcrumb' => 'Projet > Nouveau Projet',
			'instituion_tutelle_id'=> $instituion_tutelle_id,
        ]);
    }

    public function store(ProjetStoreRequest $request)
    {
        // Récupère les données validées
        $data = $request->validated();
		$data['user_id'] = auth()->id();

		$projet = Projet::create($data);


	
		
		//Récupérer les IDs de zones envoyés depuis la vue
		$zoneIds = array_filter(explode(',', $request->input('zone_ids', '')));
		$projet->zoneInterventions()->attach($zoneIds);

		//Récupérer les IDs de Positionnement stratégique envoyés depuis la vue
		$cadreLogiqueIds = array_filter(explode(',', $request->input('chaine_logique_ids', '')));
		$projet->positionnementStrategiques()->attach($cadreLogiqueIds);

        return redirect()
			->route('projets.index')
			->with('success', 'Projet enregistré avec succès.');
	
    }



	 public function associer(StoreProjetUserRequest $request)
{
    $data = $request->validated();
    
    // Préparer les données avec les bons noms de colonnes
    $associationData = [
        'projet' => $data['projet_id'],
        'userr' => $data['user_id'],
        'user_id' => auth()->id()
    ];
    
    // Vérifier si l'association existe déjà avec les bons noms de colonnes
    $existingAssociation = ProjetUser::where([
        'projet' => $associationData['projet'],
        'userr' => $associationData['userr'],
        'user_id' => auth()->id()
    ])->first();
    
    if ($existingAssociation) {
        return redirect()->route('projets.index')
            ->with('warning', 'Cette association existe déjà.');
    }
    
    $projetUSer= ProjetUser::create($associationData);

    return redirect()->route('projets.index')
        ->with('success', 'Projet associé avec succès');
}

public function dissocier($associationId)
{
    // Trouver l'association
    $association = ProjetUser::findOrFail($associationId);
    
    // Vérifier que l'utilisateur est autorisé à supprimer cette association
    // (par exemple, vérifier que l'utilisateur est le propriétaire du cadre ou de l'association)
    if ($association->user_id !== auth()->id()) {
        return redirect()->route('projets.index')
            ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette association.');
    }
    
    // Supprimer l'association
    $association->delete();
    
    return redirect()->route('projets.index')
        ->with('success', 'Association supprimée avec succès');
}

    public function show(Request $request, Projet $projet)
    {
		$zoneInterventions = $projet->zoneInterventions->pluck('intitule')->implode(', ');
		$positionnementStrategiques = $projet->positionnementStrategiques->pluck('intitule')->implode(', ');
        
		return view('projet.show', [
            'projet' => $projet,
			'zoneInterventions' => $zoneInterventions,
			'positionnementStrategiques' => $positionnementStrategiques,
			'breadcrumb' => 'Projet > Détail Projet',
        ]);
    }

    public function edit(Request $request, Projet $projet)
    {
        $projets = Projet::whereNull('deleted_on')->get();
		$statutProjets = StatutProjet::whereNull('deleted_on')->get();
		$zones = Zone::whereNull('deleted_on')->get();
		$devises = Devise::all();

		$chaineLogiques = DB::table('view_cadre_logique')->get();
		$priorites = Priorite::all();
        $populationCibles = PopulationCible::whereNull('deleted_on')->get();
		$institutionTutelles = InstitutionTutelle::whereNull('deleted_on')->get();
		$statutFinancements = StatutFinancement::whereNull('deleted_on')->get();
		$natureFinancements = NatureFinancement::whereNull('deleted_on')->get();
		$sourceFinancements = SourceFinancement::whereNull('deleted_on')->get();
		// Récupérer les zones liées au projet
		$zoneNames = $projet->zoneInterventions->pluck('intitule')->implode(', ');
		$zoneIds = $projet->zoneInterventions->pluck('id')->implode(',');
		
		// Récupérer les actions/cadre logique liées au projet
		$chaineLogiqueNames = $projet->positionnementStrategiques->pluck('intitule')->implode(', ');
		$chaineLogiqueIds = $projet->positionnementStrategiques->pluck('id')->implode(',');
		$instituion_tutelle_id=Auth::user()->institution_tutelle_id;
		
 
        return view('projet.edit', [
            'projets' => $projets,
			'projet' => $projet,
			'zones' => $zones,
			'devises' => $devises,
			'populationCibles' => $populationCibles,
			'institutionTutelles' => $institutionTutelles,
			'priorites' => $priorites,
			'statutFinancements' => $statutFinancements,
			'natureFinancements' => $natureFinancements,
			'sourceFinancements' => $sourceFinancements,
			'chaineLogiques' => $chaineLogiques,
			'statutProjets' => $statutProjets,
			'zoneNames' => $zoneNames,
			'zoneIds' => $zoneIds,
			'chaineLogiqueNames' => $chaineLogiqueNames,
			'chaineLogiqueIds' => $chaineLogiqueIds,
			'breadcrumb' => 'Projet > Mise à jour projet',
			'instituion_tutelle_id'=> $instituion_tutelle_id,
        ]);
    }

    public function update(ProjetUpdateRequest $request, Projet $projet)
    {
		$data = $request->validated();
        $projet->update($data);
		//Récupérer les IDs de zones envoyés depuis la vue
		$zoneIds = array_filter(explode(',', $request->input('zone_ids', '')));
		//Synchroniser les zones sans créer de doublons
		$projet->zoneInterventions()->sync($zoneIds);
		//Synchroniser les positionnements stratégiques sans créer de doublons
		$chaineLogiqueIds = array_filter(explode(',', $request->input('chaine_logique_ids', '')));
		$projet->positionnementStrategiques()->sync($chaineLogiqueIds);
		
        return redirect()
            ->route('projets.index')
            ->with('success', 'projet mis à jour avec succès.');

    }

    public function destroy(Request $request, Projet $projet)
    {
         $projet->deleted_on = Carbon::now();
          $projet->save();

        return redirect()->route('projets.index');
    } 
	
	public function showActionStrategieNationaleForm()
    {
		$cadre_logiques = CadreLogique::all();
        return view('projet.actionStrategieNationale',compact('cadre_logiques'));
    }
	 
	public function cadreProjet(Request $request, Projet $projet)
    {
		return view('projet.cadreProjet', [
            'projet' => $projet,
			'breadcrumb' => 'Projet > cadre stratégique',
        ]);
	}
	 
	public function storeCadreProjet(CadreDeveloppementStoreRequest $request, Projet $projet)
    {
		$data = $request->validated();
		$data['type_cadre_developpement_id'] = 2;
		$data['user_id'] = auth()->id();
		//$data['institution_tutelle_id'] = Auth::user()->institution_tutelle_id;
		$cadreDeveloppement = CadreDeveloppement::create($data);
		$projet->cadre_developpement_id = $cadreDeveloppement->id;
		$projet->save();
		return redirect()->route('cadre_developpements.cadres_logiques.index',['cadre_developpement' => $cadreDeveloppement->id])->with('success', 'cadre de projet initialisé avec succès');
    }
	
	public function editCadreProjet(Request $request, Projet $projet)
    {
		return view('projet.editCadreProjet', [
            'projet' => $projet,
			'breadcrumb' => 'Projet > Mise à jour projet',
        ]);
	}
	
	public function updateCadreProjet(CadreDeveloppementStoreRequest $request, Projet $projet)
    {
		$data = $request->validated();
		$data['type_cadre_developpement_id'] = 2;
		$projet->cadreDeveloppement->update($data);
		
		return redirect()->route('cadre_developpements.cadres_logiques.index',['cadre_developpement' => $projet->cadreDeveloppement->id])->with('success', 'cadre de projet initialisé avec succès');
    }
	
	public function populationCible(Request $request, Projet $projet)
    {
		$populationCibles = PopulationCible::whereNull('deleted_on')->get();
		return view('projet.populationCible', [
            'projet' => $projet,
			'populationCibles' => $populationCibles,
			'breadcrumb' => 'Projet > Population Cible',
        ]);
	}
	
	public function storePopulationCibles(PopulationCibleProjetStoreRequest $request, Projet $projet)
    {
		$data = $request->validated();
		//updateExistingPivot;
		$projet->populationCibles()->attach($data['population_cible_id'], ['effectif' => $data['effectif'],]);
		
		return redirect()->route('projets.populationCibles',['projet' => $projet->id])->with('success', 'population cible enregistrée avec succès');
    }
	
	public function editPopulationCibles(Request $request, Projet $projet,$populationCibleId)
    {
		$populationCibles = PopulationCible::whereNull('deleted_on')->get();
		$populationCible = $projet->populationCibles->firstwhere('pivot.population_cible_id',$populationCibleId);
		$effectif = $populationCible->pivot->effectif;
		//$populationCibleId = $populationCible->pivot->population_cible_id;
		return view('projet.editPopulationCible', [
            'projet' => $projet,
			'populationCibles' => $populationCibles,
			'effectif' => $effectif,
			'populationCibleId' => $populationCibleId,
			'breadcrumb' => 'Projet > Mise à jour population cible',
        ]);
	}
	
	public function updatePopulationCibles(PopulationCibleProjetUpdateRequest $request, Projet $projet, PopulationCible $populationCible)
    {
		$data = $request->validated();
		$projet->populationCibles()->updateExistingPivot($data['population_cible_id'], ['effectif' => $data['effectif'],]);
		
		return redirect()->route('projets.populationCibles',['projet' => $projet->id])->with('success', 'population cible enregistrée avec succès');
    }
	
	public function destroyPopulationCibles(Projet $projet, $cibleId)
    {
        $projet->populationCibles()->detach($cibleId);
		return redirect()->back()->with('success', 'Population Cible supprimée avec succès.');
		
	}
	
	public function etudeDisponibles(Request $request, Projet $projet)
    {
		$etudes = Etude::whereNull('deleted_on')->get();
		return view('projet.etudeDisponibles', [
            'projet' => $projet,
			'etudes' => $etudes,
			'breadcrumb' => 'Projet > Etudes Disponibles',
        ]);
	}
	
	public function storeEtudeDisponibles(Request $request,$projet_id)
    {
        // Validation
        $validated = $request->validate([
            'etude_id' => 'required',
            'fichier' => 'required',
        ]);
		
        // Sauvegarder le fichier
        $path = $request->file('fichier')->store('pieces', 'public');

        EtudeDisponible::create([
            'etude_id' => $validated['etude_id'],
            'fichier' => $path,
			'projet_id' => $projet_id,
        ]);

        return redirect()->back()->with('success', 'étude ajoutée avec succès.');
    }
	
	public function destroyEtudeDisponibles(Projet $projet, $etudeId)
    {
        $projet->etudeDisponibles()->detach($etudeId);
		return redirect()->back()->with('success', 'Etude supprimée avec succès.');
		
	}
	
	public function etudeEnvisagees(Request $request, Projet $projet)
    {
		$etudes = Etude::whereNull('deleted_on')->get();
		$sourceFinancements = SourceFinancement::whereNull('deleted_on')->get();
		return view('projet.etudeEnvisagees', [
            'projet' => $projet,
			'etudes' => $etudes,
			'sourceFinancements' => $sourceFinancements,
			'breadcrumb' => 'Projet > Etudes Envisagées',
        ]);
	}
	
	public function storeEtudeEnvisagees(Request $request,Projet $projet)
    {
        // Validation
        $data = $request->validate([
            'etude_id' => 'required',
            'source_financement_id' => 'required',
        ]);
		//updateExistingPivot;
		$projet->etudeEnvisagees()->attach($data['etude_id'], ['source_financement_id' => $data['source_financement_id'],]);
		
        return redirect()->back()->with('success', 'étude ajoutée avec succès.');
    
	}
	
	public function destroyEtudeEnvisagees(Projet $projet, $etudeId,)
    {
        $projet->etudeEnvisagees()->detach($etudeId);
		return redirect()->back()->with('success', 'Etude supprimée avec succès.');
		
	}
	public function editEtudeEnvisagees(Request $request, Projet $projet, Etude $etude, SourceFinancement $sourceFinancement)
    {
		$etudes = Etude::whereNull('deleted_on')->get();
		$sourceFinancements = SourceFinancement::whereNull('deleted_on')->get();
		return view('projet.editEtudeEnvisagees', [
            'projet' => $projet,
			'etudeId' => $etude->id,
			'sourceFinancementId' => $sourceFinancement->id,
			'etudes' => $etudes,
			'sourceFinancements' => $sourceFinancements,
			'breadcrumb' => 'Projet > Mise à jour Etude envisagée',
        ]);
	}
	
	public function updateEtudeEnvisagees(Request $request, Projet $projet, Etude $etude, SourceFinancement $sourceFinancement)
    {
		// Validation
        $data = $request->validate([
            'etude_id' => 'required',
            'source_financement_id' => 'required',
        ]);
		// Recherche de l'enregistrement existant
		$etudeEnvisagee = EtudeEnvisagee::where('projet_id', $projet->id)
        ->where('etude_id', $etude->id)
        ->where('source_financement_id', $sourceFinancement->id)
        ->first();
		
		// Si non trouvé → erreur
		if (!$etudeEnvisagee) {
			return redirect()->back()->with('error', 'Étude envisagée introuvable.');
		}
		
		// Mise à jour
		$etudeEnvisagee->update([
			'etude_id' => $data['etude_id'],
			'source_financement_id' => $data['source_financement_id'],
		]);
        return redirect()->route('projets.etudeEnvisagees',['projet' => $projet->id])->with('success', 'Etude envisagée mise à jour avec succès.');
	}
	
	public function rechercheFinancements(Request $request, Projet $projet)
    {
		$sourceFinancements = SourceFinancement::whereNull('deleted_on')->get();
		$bailleurs = Bailleur::whereNull('deleted_on')->get();
		$natureFinancements = NatureFinancement::whereNull('deleted_on')->get();
		$statutFinancements = StatutFinancement::whereNull('deleted_on')->get();
		return view('projet.rechercheFinancements', [
            'projet' => $projet,
			'sourceFinancements' => $sourceFinancements,
			'natureFinancements' => $natureFinancements,
			'statutFinancements' => $statutFinancements,
			'bailleurs' => $bailleurs,
			'breadcrumb' => 'Projet > Recherches Financements',
        ]);
	}
	
	public function storeRechercheFinancements(Request $request,Projet $projet)
    {
        // Validation
        $data = $request->validate([
            'bailleur_id' => 'required',
            'source_financement_id' => 'required',
			'statut_financement_id' => 'required',
			'nature_financement_id' => 'required',
			'montant' => 'required',
        ]);
		//updateExistingPivot;
		$projet->rechercheFinancements()->attach($data['source_financement_id'], ['bailleur_id' => $data['bailleur_id'], 'statut_financement_id' => $data['statut_financement_id'], 'nature_financement_id' => $data['nature_financement_id'], 'montant' => $data['montant'],]);
		
        return redirect()->back()->with('success', 'étude ajoutée avec succès.');
    
	}
	
	public function destroyRechercheFinancements($projetId, $bailleurId, $sourceFinancementId, $statutFinancementId, $natureFinancementId)
    {
        RechercheFinancement::where('projet_id',$projetId)->where('bailleur_id', $bailleurId)->where('source_financement_id', $sourceFinancementId)->where('statut_financement_id', $statutFinancementId)->where('nature_financement_id', $natureFinancementId)->delete();
		return redirect()->back()->with('success', 'recherche de financement supprimée avec succès.');
		
	}
	public function editRechercheFinancements(Request $request, Projet $projet, $bailleurId, $sourceFinancementId, $statutFinancementId, $natureFinancementId)
    {
		$sourceFinancements = SourceFinancement::whereNull('deleted_on')->get();
		$bailleurs = Bailleur::whereNull('deleted_on')->get();
		$natureFinancements = NatureFinancement::whereNull('deleted_on')->get();
		$statutFinancements = StatutFinancement::whereNull('deleted_on')->get();
		$PF = RechercheFinancement::where('projet_id',$projet->id)->where('bailleur_id', $bailleurId)->where('source_financement_id', $sourceFinancementId)->where('statut_financement_id', $statutFinancementId)->where('nature_financement_id', $natureFinancementId)->first();
		return view('projet.editRechercheFinancements', [
            'projet' => $projet,
			'sourceFinancements' => $sourceFinancements,
			'natureFinancements' => $natureFinancements,
			'statutFinancements' => $statutFinancements,
			'bailleurs' => $bailleurs,
			'bailleurId' => $bailleurId,
			'sourceFinancementId' => $sourceFinancementId,
			'statutFinancementId' => $statutFinancementId,
			'natureFinancementId' => $natureFinancementId,
			'montant' => $PF->montant,
			'breadcrumb' => 'Projet > Mise à jour recherche financement',
        ]);
	}
	
	public function updateRechercheFinancements(Request $request, Projet $projet)
    {
		// Validation
        $data = $request->validate([
            'bailleur_id' => 'required',
            'source_financement_id' => 'required',
			'statut_financement_id' => 'required',
			'nature_financement_id' => 'required',
			'montant' => 'required',
        ]);
		// Recherche de l'enregistrement existant
		$PF = RechercheFinancement::where('projet_id', $projet->id)
        ->where('source_financement_id', $data['source_financement_id'])
		->where('statut_financement_id', $data['statut_financement_id'])
		->where('nature_financement_id', $data['nature_financement_id'])
		->where('bailleur_id', $data['bailleur_id'])
        ->first();
		
		// Si non trouvé → erreur
		if (!$PF) {
			return redirect()->back()->with('error', 'Recherche Financement introuvable.');
		}
		
		// Mise à jour
		//$projet->rechercheFinancements()->attach($data['source_financement_id'], ['bailleur_id' => $data['bailleur_id'], 'statut_financement_id' => $data['statut_financement_id'], 'nature_financement_id' => $data['nature_financement_id'], 'montant' => $data['montant'],]);
		
		$PF->update([
			'source_financement_id' => $data['source_financement_id'],   
			'statut_financement_id' => $data['statut_financement_id'],
			'nature_financement_id' => $data['nature_financement_id'],
			'bailleur_id' => $data['bailleur_id'],
			'montant' => $data['montant'],
		]);
        return redirect()->route('projets.rechercheFinancements',['projet' => $projet->id])->with('success', 'recherchefinancement mis à jour avec succès.');
	}
	
	public function planFinancements(Request $request, Projet $projet)
    {
		$composantes = Composante::where('projet_id', $projet->id)->get();
		$sourceFinancements = SourceFinancement::whereNull('deleted_on')->get();
		$bailleurs = Bailleur::whereNull('deleted_on')->get();
		$natureFinancements = NatureFinancement::whereNull('deleted_on')->get();
		$statutFinancements = StatutFinancement::whereNull('deleted_on')->get();
		$categorieDepenses = CategorieDepense::whereNull('deleted_on')->get();
		$planFinancements = PlanFinancement::where('projet_id', $projet->id)->get();
		

		return view('projet.planFinancements', [
            'projet' => $projet,
			'planFinancements' => $planFinancements,
			'composantes' => $composantes,
			'sourceFinancements' => $sourceFinancements,
			'natureFinancements' => $natureFinancements,
			'statutFinancements' => $statutFinancements,
			'categorieDepenses' => $categorieDepenses,
			'bailleurs' => $bailleurs,
			'breadcrumb' => 'Projet > Plans Financements',
        ]);
	}
	
	public function storePlanFinancements(Request $request,Projet $projet)
    {
        // Validation 
        $data = $request->validate([
            'bailleur_id' => 'required',
			'composante_ids' => 'required',
            'source_financement_id' => 'required',
			'statut_financement_id' => 'required',
			'nature_financement_id' => 'required',
			'categorie_depense_id' => 'required',
			'montant' => 'required',
        ]);
		$composanteId = $request->composante_ids;
		
		//updateExistingPivot;
		$projet->planFinancements()->attach($data['source_financement_id'], ['bailleur_id' => $data['bailleur_id'], 'statut_financement_id' => $data['statut_financement_id'], 'nature_financement_id' => $data['nature_financement_id'], 'composante_id' => $composanteId, 'categorie_depense_id' => $data['categorie_depense_id'], 'montant' => $data['montant'],]);
		
        return redirect()->back()->with('success', 'plan de fiancement  ajoutée avec succès.');
    
	}
	
	public function destroyPlanFinancements($projetId, $composanteId, $sourceFinancementId, $bailleurId, $categorieDepenseId, $natureFinancementId, $statutFinancementId)
    {
		PlanFinancement::where('projet_id',$projetId)->where('bailleur_id', $bailleurId)->where('source_financement_id', $sourceFinancementId)->where('statut_financement_id', $statutFinancementId)->where('nature_financement_id', $natureFinancementId)->where('categorie_depense_id', $categorieDepenseId)->where('composante_id', $composanteId)->delete();
		return redirect()->back()->with('success', 'plan de financement supprimée avec succès.');
		
	}
	
	public function editPlanFinancements(Request $request, Projet $projet, $composanteId, $sourceFinancementId, $bailleurId, $categorieDepenseId, $natureFinancementId, $statutFinancementId)
    {
		$composantes = Composante::where('projet_id', $projet)->get();
		$sourceFinancements = SourceFinancement::whereNull('deleted_on')->get();
		$bailleurs = Bailleur::whereNull('deleted_on')->get();
		$natureFinancements = NatureFinancement::whereNull('deleted_on')->get();
		$statutFinancements = StatutFinancement::whereNull('deleted_on')->get();
		$categorieDepenses = CategorieDepense::whereNull('deleted_on')->get();
		//$PF = PlanFinancement::where('projet_id',$projet->id)->where('bailleur_id', $bailleurId)->where('source_financement_id', $sourceFinancementId)->where('statut_financement_id', $statutFinancementId)->where('nature_financement_id', $natureFinancementId)->where('statut_montant_id', $statutMontantId)->where('composante_id', $composanteId)->where('categorie_depense_id', $categorieDepenseId)->first();

		$planFinancement = PlanFinancement::where('projet_id',$projet->id)->where('bailleur_id', $bailleurId)->where('source_financement_id', $sourceFinancementId)->where('statut_financement_id', $statutFinancementId)->where('nature_financement_id', $natureFinancementId)->where('categorie_depense_id', $categorieDepenseId)->where('composante_id', $composanteId)->first();
		//PlanFinancement::where('projet_id',$projet->id)->where('bailleur_id', $bailleurId)->where('source_financement_id', $sourceFinancementId)->where('statut_financement_id', $statutFinancementId)->where('nature_financement_id', $natureFinancementId)->where('statut_montant_id', $statutMontantId)->where('composante_id', $composanteId)->where('categorie_depense_id', $categorieDepenseId)->first();
		return view('projet.editPlanFinancements', [
            'projet' => $projet,
			'planFinancement' => $planFinancement,
			'composantes' => $composantes,
			'sourceFinancements' => $sourceFinancements,
			'natureFinancements' => $natureFinancements,
			'statutFinancements' => $statutFinancements,
			'bailleurs' => $bailleurs,
			'bailleurId' => $bailleurId,
			'categorieDepenses' => $categorieDepenses,
			'categorieDepenseId' => $categorieDepenseId,
			'sourceFinancementId' => $sourceFinancementId,
			'statutFinancementId' => $statutFinancementId,
			'natureFinancementId' => $natureFinancementId,
			'composanteId' => $composanteId,
			'montant' => $planFinancement->montant,
			'breadcrumb' => 'Projet > Mise à jour plan financement',
        ]);
	}
	
	public function updatePlanFinancements(Request $request, Projet $projet, PlanFinancement $planFinancement)
    {
		// Validation
        $data = $request->validate([
            'composante_ids' => 'required',
			'bailleur_id' => 'required',
            'source_financement_id' => 'required',
			'statut_financement_id' => 'required',
			'nature_financement_id' => 'required',
			'categorie_depense_id' => 'required',
			'montant' => 'required',
        ]);
		
		$planFinancement->update([
			'source_financement_id' => $data['source_financement_id'],   
			'statut_financement_id' => $data['statut_financement_id'],
			'nature_financement_id' => $data['nature_financement_id'],
			'bailleur_id' => $data['bailleur_id'],
			'composante_id' => $request->composante_ids,
			'categorie_depense_id' => $data['categorie_depense_id'],
			'montant' => $data['montant'],
		]);
        return redirect()->route('projets.planFinancements',['projet' => $projet->id])->with('success', 'plan financement mis à jour avec succès.');
	}
	
	public function budgetAnnuelPrevu(Request $request, Projet $projet, $composanteId, $sourceFinancementId, $bailleurId, $categorieDepenseId, $natureFinancementId, $statutFinancementId)
    {
		$planFinancement = PlanFinancement::where('projet_id',$projet->id)->where('bailleur_id', $bailleurId)->where('source_financement_id', $sourceFinancementId)->where('statut_financement_id', $statutFinancementId)->where('nature_financement_id', $natureFinancementId)->where('categorie_depense_id', $categorieDepenseId)->where('composante_id', $composanteId)->first();
		$budgets = $planFinancement->budgetsAnnuelsPrevus;
		$categorieDepenses = CategorieDepense::whereNull('deleted_on')->get();
		
		return view('projet.budgetAnnuelPrevu', [
            'projet' => $projet,
			'planFinancement' => $planFinancement,
			'budgets' => $budgets,
			'categorieDepenses' => $categorieDepenses,
			'breadcrumb' => 'Projet > Montants prévus par année',
        ]);
	}
	
	public function storeBudgetAnnuelPrevu(Request $request,Projet $projet,PlanFinancement $planFinancement)
    {
        // Validation
        $data = $request->validate([
            'categorie_depense_id' => 'required',
			'annee' => 'required',
			'montant' => 'required',
        ]);
		
		$planFinancement->budgetsAnnuelsPrevus()->create([
			'categorie_depense_id'   => $data['categorie_depense_id'],
			'annee'   => $data['annee'],
			'montant' => $data['montant'],
		]);
        return redirect()->back()->with('success', 'montant annuel prévu ajoutée avec succès.');
    
	}
	public function editBudgetAnnuelPrevu(Request $request, Projet $projet, BudgetAnnuelPrevu $budgetAnnuelPrevu)
    {
		$categorieDepenses = CategorieDepense::whereNull('deleted_on')->get();
        return view('projet.editBudgetAnnuelPrevu', [
            'projet' => $projet,
			'budgetAnnuelPrevu' => $budgetAnnuelPrevu,
			'categorieDepenses' => $categorieDepenses,
			'breadcrumb' => 'Reférentiel > Mise à jour catégorie dépense',
        ]);
    }

    public function updateBudgetAnnuelPrevu(Request $request,Projet $projet, BudgetAnnuelPrevu $budgetAnnuelPrevu)
    {
        // Validation
        $data = $request->validate([
            'categorie_depense_id' => 'required',
			'annee' => 'required',
			'montant' => 'required',
        ]);
		
		$budgetAnnuelPrevu->update($data);

        return redirect()->back()->with('success', 'montant annuel prévu modifié avec succès.');
    }
	
	public function destroyBudgetAnnuelPrevu(Request $request,Projet $projet, BudgetAnnuelPrevu $budgetAnnuelPrevu)
    {
         $projet->deleted_on = Carbon::now();
          $projet->save();

        return redirect()->back()->with('success', 'montant annuel prévu supprimé avec succès.');
    }
	
	public function budgetAnnuelDepense(Request $request, Projet $projet, $composanteId, $sourceFinancementId, $bailleurId, $categorieDepenseId, $natureFinancementId, $statutFinancementId)
    {
		$planFinancement = PlanFinancement::where('projet_id',$projet->id)->where('bailleur_id', $bailleurId)->where('source_financement_id', $sourceFinancementId)->where('statut_financement_id', $statutFinancementId)->where('nature_financement_id', $natureFinancementId)->where('categorie_depense_id', $categorieDepenseId)->where('composante_id', $composanteId)->first();
		$budgets = $planFinancement->budgetsAnnuelsDepenses;
		$categorieDepenses = CategorieDepense::all();
		
		return view('projet.budgetAnnuelDepense', [
            'projet' => $projet,
			'planFinancement' => $planFinancement,
			'budgets' => $budgets,
			'categorieDepenses' => $categorieDepenses,
			'breadcrumb' => 'Projet > Montants dépensé par année',
        ]);
	}
	
	public function storeBudgetAnnuelDepense(Request $request,Projet $projet,PlanFinancement $planFinancement)
    {
        // Validation
        $data = $request->validate([
            'categorie_depense_id' => 'required',
			'annee' => 'required',
			'montant' => 'required',
        ]);
		
		$planFinancement->budgetsAnnuelsDepenses()->create([
			'categorie_depense_id'   => $data['categorie_depense_id'],
			'annee'   => $data['annee'],
			'montant' => $data['montant'],
		]);
        return redirect()->back()->with('success', 'montant annuel dépensé ajoutée avec succès.');
    
	}
	public function editBudgetAnnuelDepense(Request $request, Projet $projet, BudgetAnnuelDepense $budgetAnnuelDepense)
    {
		$categorieDepenses = CategorieDepense::all();
        return view('projet.editBudgetAnnuelDepense', [
            'projet' => $projet,
			'budgetAnnuelDepense' => $budgetAnnuelDepense,
			'categorieDepenses' => $categorieDepenses,
			'breadcrumb' => 'Reférentiel > Mise à jour montant annuel dépensé',
        ]);
    }

    public function updateBudgetAnnuelDepense(Request $request,Projet $projet, BudgetAnnuelDepense $budgetAnnuelDepense)
    {
        // Validation
        $data = $request->validate([
            'categorie_depense_id' => 'required',
			'annee' => 'required',
			'montant' => 'required',
        ]);
		
		$budgetAnnuelDepense->update($data);

        return redirect()->back()->with('success', 'montant annuel dépensé modifié avec succès.');
    }
	
	public function destroyBudgetAnnuelDepense(Request $request,Projet $projet, BudgetAnnuelDepense $budgetAnnuelDepense)
    {
        $budgetAnnuelDepense->delete();

        return redirect()->back()->with('success', 'montant annuel dépensé supprimé avec succès.');
    }
	
	public function budgetAnnuel(Request $request, Projet $projet, $composanteId, $sourceFinancementId, $bailleurId, $categorieDepenseId, $natureFinancementId, $statutFinancementId)
    {
		$planFinancement = PlanFinancement::where('projet_id',$projet->id)->where('bailleur_id', $bailleurId)->where('source_financement_id', $sourceFinancementId)->where('statut_financement_id', $statutFinancementId)->where('nature_financement_id', $natureFinancementId)->where('categorie_depense_id', $categorieDepenseId)->where('composante_id', $composanteId)->first();
		$budgets = $planFinancement->budgetsAnnuels;
		$categorieDepenses = CategorieDepense::all();
		
		return view('projet.budgetAnnuel', [
            'projet' => $projet,
			'planFinancement' => $planFinancement,
			'budgets' => $budgets,
			'categorieDepenses' => $categorieDepenses,
			'breadcrumb' => 'Projet > Montants budgétisés par année',
        ]);
	}
	
	public function storeBudgetAnnuel(Request $request,Projet $projet,PlanFinancement $planFinancement)
    {
        // Validation
        $data = $request->validate([
            'categorie_depense_id' => 'required',
			'annee' => 'required',
			'montant' => 'required',
        ]);
		
		$planFinancement->budgetsAnnuels()->create([
			'categorie_depense_id'   => $data['categorie_depense_id'],
			'annee'   => $data['annee'],
			'montant' => $data['montant'],
		]);
        return redirect()->back()->with('success', 'montant annuel budgétisé ajouté avec succès.');
    
	}
	public function editBudgetAnnuel(Request $request, Projet $projet, BudgetAnnuel $budgetAnnuel)
    {
		$categorieDepenses = CategorieDepense::all();
        return view('projet.editBudgetAnnuel', [
            'projet' => $projet,
			'budgetAnnuel' => $budgetAnnuel,
			'categorieDepenses' => $categorieDepenses,
			'breadcrumb' => 'Reférentiel > Mise à jour montant annuel budgétisé',
        ]);
    }

    public function updateBudgetAnnuel(Request $request,Projet $projet, BudgetAnnuel $budgetAnnuel)
    {
        // Validation
        $data = $request->validate([
            'categorie_depense_id' => 'required',
			'annee' => 'required',
			'montant' => 'required',
        ]);
		
		$budgetAnnuel->update($data);

        return redirect()->back()->with('success', 'montant annuel budgétisé modifié avec succès.');
    }
	
	public function destroyBudgetAnnuel(Request $request,Projet $projet, BudgetAnnuel $budgetAnnuel)
    {
        $budgetAnnuel->delete();

        return redirect()->back()->with('success', 'montant annuel budgétisé supprimé avec succès.');
    }
	
	public function clotureProjets(Request $request, Projet $projet)
    {
		$clotureProjet = ClotureProjet::where('projet_id', $projet->id)->get();
		return view('projet.clotureProjets', [
            'projet' => $projet,
			'clotureProjet' => $clotureProjet,
			'breadcrumb' => 'Projet > Cloture du projet',
        ]);
	}
	
	public function storeClotureProjets(Request $request,Projet $projet)
    {
        // Validation 
        $data = $request->validate([
            'cout_effectif' => 'required',
			'date_debut_effectif' => 'required',
			'date_fin_effectif' => 'required',
			'duree_effectif' => 'required',
			'rapport_achevement' => 'required',
			'conclusion_rapport_achevement',
			'date_rapport_achevement',
			'rapport_cloture',
			'conclusion_rapport_cloture',
			'date_rapport_cloture' => 'required',
			'date_fermeture_comptes' => 'required',
			'reference_document_fermeture_comptes' => 'required',
			
        ]);
		// Sauvegarder le fichier
        $data['rapport_achevement'] = $request->file('rapport_achevement')->store('pieces', 'public');
		$data['rapport_cloture'] = $request->file('rapport_cloture')->store('pieces', 'public');
		$data['projet_id'] = $projet->id;
		$clotureProjet = ClotureProjet::create($data);
		
        return redirect()->back()->with('success', 'Projet clôturé avec succès.');
    
	}
	
	public function destroyClotureProjets(Projet $projet, ClotureProjet $clotureProjet)
    {
		$clotureProjet->delete();
		return redirect()->back()->with('success', 'clôture de projet supprimée avec succès.');
    
		
	}
	
	public function editClotureProjets(Request $request, Projet $projet, ClotureProjet $clotureProjet)
    {
		return view('projet.editClotureProjets', [
            'projet' => $projet,
			'clotureProjet' => $clotureProjet,
			'breadcrumb' => 'Projet > Mise à jour clôture projet',
        ]);
	}
	
	public function updateClotureProjets(Request $request, Projet $projet, ClotureProjet $clotureProjet)
    {
		// Validation
        $data = $request->validate([
            'cout_effectif' => 'required',
			'date_debut_effectif' => 'required',
			'date_fin_effectif' => 'required',
			'duree_effectif' => 'required',
			'rapport_achevement' => 'required',
			'conclusion_rapport_achevement',
			'date_rapport_achevement',
			'rapport_cloture',
			'conclusion_rapport_cloture',
			'date_rapport_cloture' => 'required',
			'date_fermeture_comptes' => 'required',
			'reference_document_fermeture_comptes' => 'required',
			
        ]);
		
		$clotureProjet->update($data);
        return redirect()->back()->with('success', 'clôture de projet modifiée avec succès.');
    
	}
	
}
