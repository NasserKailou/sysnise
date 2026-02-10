<?php

namespace App\Http\Controllers;

//use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Database\UniqueConstraintViolationException;
use App\Http\Requests\StoreCadreDeveloppementInstitutionRequest;
use App\Http\Requests\StoreCadreDeveloppementUserRequest;
use App\Models\CadreDeveloppementInstitution;
use App\Models\CadreDeveloppementUser;
use App\Models\InstitutionTutelle;
use App\Models\CD_FinancementParBailleur;
use App\Models\CD_FinancementParResultat;
use App\Models\Composante;
use App\Models\Bailleur;
use App\Models\CadreLogique;
use App\Models\CD_FinancementAnnuelParBailleur;
use App\Models\CD_FinancementAnnuelParResultat;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CadreDeveloppementStoreRequest;
use App\Http\Requests\CadreDeveloppementUpdateRequest;
use App\Models\CadreDeveloppement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Session;

class CadreDeveloppementController extends Controller
{
    public function index(Request $request)
    {
       // $cadreDeveloppements = CadreDeveloppement::where('type_cadre_developpement_id', 1)
            //->where('user_id', auth()->id())
           // ->where('institution_tutelle_id', Auth::user()->institution_tutelle_id)
          // ->with(['cadreDeveloppementUsers.userr']) // Charger les associations avec l'institution
           // ->get();

           $user = Auth::user();

           $cadreDeveloppements = CadreDeveloppement::where('type_cadre_developpement_id', 1)
    ->where(function($query) use ($user) {
        // Condition 1: Institution tutelle de l'utilisateur
        $query->where('institution_tutelle_id', $user->institution_tutelle_id)
              // Condition 2: OU associé à l'utilisateur connecté
              ->orWhereHas('cadreDeveloppementUsers', function($q) use ($user) {
                  $q->where('userr', $user->id);
              });
    })
    ->with(['cadreDeveloppementUsers.userr'])
    ->get();


        $currentUserInstitutionId = Auth::user()->institution_tutelle_id;
             $users = User::where('institution_tutelle_id', '!=', $currentUserInstitutionId)
        //->whereNull('deleted_on')
        ->get();
      

        return view('cadreDeveloppement.index', [
            'breadcrumb' => 'Cadres stratégiques > Liste des cadres',
			'cadreDeveloppements' => $cadreDeveloppements, 'users' =>$users
        ]);
    }

    public function create(Request $request)
    {
		$chaineLogiques = DB::table('view_cadre_logique')->get();
		return view('cadreDeveloppement.create',[
            'breadcrumb' => 'Cadres stratégiques > Nouveau',
			'chaineLogiques' => $chaineLogiques,	
        ]);
    }

    public function store(CadreDeveloppementStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['institution_tutelle_id'] = Auth::user()->institution_tutelle_id;

		$cadreDeveloppement = CadreDeveloppement::create($data);
		//Récupérer les IDs de Positionnement stratégique envoyés depuis la vue
		$cadreLogiqueIds = array_filter(explode(',', $request->input('chaine_logique_ids', '')));
		$cadreDeveloppement->alignementStrategiques()->attach($cadreLogiqueIds);

        return redirect()->route('cadre_developpements.index')->with('success', 'cadre de développement créé avec succès');
    }


     public function associer(StoreCadreDeveloppementUserRequest $request)
{
    $data = $request->validated();
    
    // Préparer les données avec les bons noms de colonnes
    $associationData = [
        'cadre_developpement' => $data['cadre_developpement_id'],
        'userr' => $data['user_id'],
        'user_id' => auth()->id()
    ];
    
    // Vérifier si l'association existe déjà avec les bons noms de colonnes
    $existingAssociation = CadreDeveloppementUser::where([
        'cadre_developpement' => $associationData['cadre_developpement'],
        'userr' => $associationData['userr'],
        'user_id' => auth()->id()
    ])->first();
    
    if ($existingAssociation) {
        return redirect()->route('cadre_developpements.index')
            ->with('warning', 'Cette association existe déjà.');
    }
    
    $cadreDeveloppementUser= CadreDeveloppementUser::create($associationData);

    return redirect()->route('cadre_developpements.index')
        ->with('success', 'Cadre de développement associé avec succès');
}

public function dissocier($associationId)
{
    // Trouver l'association
    $association = CadreDeveloppementUser::findOrFail($associationId);
    
    // Vérifier que l'utilisateur est autorisé à supprimer cette association
    // (par exemple, vérifier que l'utilisateur est le propriétaire du cadre ou de l'association)
    if ($association->user_id !== auth()->id()) {
        return redirect()->route('cadre_developpements.index')
            ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette association.');
    }
    
    // Supprimer l'association
    $association->delete();
    
    return redirect()->route('cadre_developpements.index')
        ->with('success', 'Association supprimée avec succès');
}

    public function show(Request $request, CadreDeveloppement $cadreDeveloppement)
    {
        

        if (
             $cadreDeveloppement->institution_tutelle_id !== Auth::user()->institution_tutelle_id
        ) {
            Session::flash('error', 'Accès non autorisé');
            return redirect()->back();//->with('error', 'Accès non autorisé');
        }

        return view('cadreDeveloppement.show', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'breadcrumb' => 'Cadres stratégiques > Pièces Jointes',
		]);
    }

    public function edit(Request $request, CadreDeveloppement $cadreDeveloppement)
    {
		$chaineLogiques = DB::table('view_cadre_logique')->get();
		// Récupérer les actions/cadre logique d'alignement
		$chaineLogiqueNames = $cadreDeveloppement->alignementStrategiques->pluck('intitule')->implode(', ');
		$chaineLogiqueIds = $cadreDeveloppement->alignementStrategiques->pluck('id')->implode(',');
		
        return view('cadreDeveloppement.edit', [
            'breadcrumb' => 'Cadres stratégiques > Mise à jour',
			'cadreDeveloppement' => $cadreDeveloppement,
			'chaineLogiques' => $chaineLogiques,
			'chaineLogiqueNames' => $chaineLogiqueNames,
			'chaineLogiqueIds' => $chaineLogiqueIds,
        ]);
    }

    public function update(CadreDeveloppementUpdateRequest $request, CadreDeveloppement $cadreDeveloppement)
    {
        $cadreDeveloppement->update($request->validated());
		//Synchroniser les positionnements stratégiques sans créer de doublons
		$chaineLogiqueIds = array_filter(explode(',', $request->input('chaine_logique_ids', '')));
		$cadreDeveloppement->alignementStrategiques()->sync($chaineLogiqueIds);
        return redirect()->route('cadre_developpements.index')->with('success', 'cadre de développement modifié avec succès');

    }

    public function destroy(Request $request, CadreDeveloppement $cadreDeveloppement)
    {
        $cadreDeveloppement->delete();

        return redirect()->route('cadre_developpements.index')->with('success', 'cadre de développement supprimé avec succès');
    }
	
	//financement par Bailleur
	public function financementParBailleur(Request $request, CadreDeveloppement $cadreDeveloppement)
    {
		$bailleurs = Bailleur::whereNull('deleted_on')->get();
		$financementParBailleurs = CD_FinancementParBailleur::where('cadre_developpement_id', $cadreDeveloppement->id)->whereNotNull('bailleur_id')->whereNull('deleted_on')->get();
		return view('cadreDeveloppement.financementParBailleur', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'financementParBailleurs' => $financementParBailleurs,
			'bailleurs' => $bailleurs,
			'breadcrumb' => 'CadreDeveloppement > Financements par bailleur',
        ]);
	}
	
	public function storeFinancementParBailleur(Request $request,CadreDeveloppement $cadreDeveloppement)
    {
        
		try{
			// Validation 
			$data = $request->validate([
				'bailleur_id' => 'required',
				'montant' => 'required',
			]);
			$cadreDeveloppement->financementParBailleurs()->create([
				'montant' => $data['montant'],
				'bailleur_id' => $data['bailleur_id'],
			]);
			
			return redirect()->back()->with('success', 'plan de fiancement  ajoutée avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un plan de financement existe déjà pour ce bailleur.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	
	public function editFinancementParBailleur(Request $request, CadreDeveloppement $cadreDeveloppement, $financementId)
    {
		$bailleurs = Bailleur::whereNull('deleted_on')->get();
		//$financementParBailleur = CD_FinancementParBailleur::where('cadre_developpement_id',$cadreDeveloppement->id)->where('bailleur_id', $bailleurId)->first();
		$financementParBailleur = CD_FinancementParBailleur::where('id',$financementId)->first();
		return view('cadreDeveloppement.editFinancementParBailleur', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'financementParBailleur' => $financementParBailleur,
			'bailleurs' => $bailleurs,
			'bailleurId' => $financementParBailleur->bailleur_id,
			'montant' => $financementParBailleur->montant,
			'breadcrumb' => 'CadreDeveloppement > Mise à jour Financement par catégorie de dépense',
        ]);
	}
	
	public function updateFinancementParBailleur(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementParBailleur $financementParBailleur)
    {
		
		try{
			// Validation 
			$data = $request->validate([
				'bailleur_id' => 'required',
				'montant' => 'required',
			]);
			
			$financementParBailleur->update([
			'bailleur_id' => $data['bailleur_id'],
			'montant' => $data['montant'],
		]);
        return redirect()->route('cadre_developpements.financementParBailleur',['cadre_developpement' => $cadreDeveloppement->id])->with('success', 'financement par catégorie de dépense mis à jour avec succès.');
			
			
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un plan de financement existe déjà pour ce bailleur.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
		
	}
	
	public function destroyFinancementParBailleur(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementParBailleur $financementParBailleur)
    {
         $financementParBailleur->deleted_on = Carbon::now();
         $financementParBailleur->save();

        return redirect()->back()->with('success', 'plan de financement supprimé avec succès.');
    }
	
	public function montantMobiliseFB(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementParBailleur $financementParBailleur)
    {
		$montantMobilises = $financementParBailleur->montantMobilises->whereNull('deleted_on')->where('statut_montant_financement_id',1);
		
		return view('cadreDeveloppement.montantMobiliseFB', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'financementParBailleur' => $financementParBailleur,
			'montantMobilises' => $montantMobilises,
			'breadcrumb' => 'CadreDeveloppement > Montants prévus par année',
        ]);
	}
	
	public function storeMontantMobiliseFB(Request $request,CadreDeveloppement $cadreDeveloppement,CD_FinancementParBailleur $financementParBailleur)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$financementParBailleur->montantMobilises()->create([
				'annee'   => $data['annee'],
				'montant' => $data['montant'],
				'statut_montant_financement_id' => 1,
			]);
			
			return redirect()->back()->with('success', 'montant annuel mobilisé ajoutée avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel mobilisé existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	public function editMontantMobiliseFB(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParBailleur $montantMobilise)
    {
		return view('cadreDeveloppement.editMontantMobiliseFB', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'montantMobilise' => $montantMobilise,
			'breadcrumb' => 'Reférentiel > Mise à jour catégorie dépense',
        ]);
    }

    public function updateMontantMobiliseFB(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParBailleur $montantMobilise)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$montantMobilise->update($data);
			
			return redirect()->back()->with('success', 'montant annuel mobilisé modifié avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel mobilisé existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	
	public function destroyMontantMobiliseFB(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParBailleur $montantMobilise)
    {
         $montantMobilise->deleted_on = Carbon::now();
         $montantMobilise->save();

        return redirect()->back()->with('success', 'montant annuel prévu supprimé avec succès.');
    }
	
	
	public function montantConsommeFB(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementParBailleur $financementParBailleur)
    {
		$montantConsommes = $financementParBailleur->montantConsommes->whereNull('deleted_on')->where('statut_montant_financement_id',2);
		
		return view('cadreDeveloppement.montantConsommeFB', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'financementParBailleur' => $financementParBailleur,
			'montantConsommes' => $montantConsommes,
			'breadcrumb' => 'CadreDeveloppement > Montants consommé par année',
        ]);
	}
	
	public function storeMontantConsommeFB(Request $request,CadreDeveloppement $cadreDeveloppement,CD_FinancementParBailleur $financementParBailleur)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$financementParBailleur->montantConsommes()->create([
				'annee'   => $data['annee'],
				'montant' => $data['montant'],
				'statut_montant_financement_id' => 2,
			]);
			
			return redirect()->back()->with('success', 'montant annuel consommé ajoutée avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel consommé existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	public function editMontantConsommeFB(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParBailleur $montantConsomme)
    {
		return view('cadreDeveloppement.editMontantConsommeFB', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'montantConsomme' => $montantConsomme,
			'breadcrumb' => 'Reférentiel > Mise à jour montant consommé',
        ]);
    }

    public function updateMontantConsommeFB(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParBailleur $montantConsomme)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$montantConsomme->update($data);
			
			return redirect()->back()->with('success', 'montant annuel consommé modifié avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel consommé existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	
	public function destroyMontantConsommeFB(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParBailleur $montantConsomme)
    {
         $montantConsomme->deleted_on = Carbon::now();
         $montantConsomme->save();

        return redirect()->back()->with('success', 'montant annuel consommé supprimé avec succès.');
    }
	
	public function montantRechercheFB(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementParBailleur $financementParBailleur)
    {
		$montantRecherches = $financementParBailleur->montantRecherches->whereNull('deleted_on')->where('statut_montant_financement_id',3);
		
		return view('cadreDeveloppement.montantRechercheFB', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'financementParBailleur' => $financementParBailleur,
			'montantRecherches' => $montantRecherches,
			'breadcrumb' => 'CadreDeveloppement > Montants recherché par année',
        ]);
	}
	
	public function storeMontantRechercheFB(Request $request,CadreDeveloppement $cadreDeveloppement,CD_FinancementParBailleur $financementParBailleur)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$financementParBailleur->montantRecherches()->create([
				'annee'   => $data['annee'],
				'montant' => $data['montant'],
				'statut_montant_financement_id' => 3,
			]);
			
			return redirect()->back()->with('success', 'montant annuel recherché ajoutée avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel recherché existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	public function editMontantRechercheFB(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParBailleur $montantRecherche)
    {
		return view('cadreDeveloppement.editMontantRechercheFB', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'montantRecherche' => $montantRecherche,
			'breadcrumb' => 'Reférentiel > Mise à jour montant annuel recherché',
        ]);
    }

    public function updateMontantRechercheFB(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParBailleur $montantRecherche)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$montantRecherche->update($data);
			
			return redirect()->back()->with('success', 'montant annuel recherché modifié avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel recherché existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	
	public function destroyMontantRechercheFB(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParBailleur $montantRecherche)
    {
         $montantRecherche->deleted_on = Carbon::now();
         $montantRecherche->save();

        return redirect()->back()->with('success', 'montant annuel recherché supprimé avec succès.');
    }
	
	//financement par Resultat
	public function financementParResultat(Request $request, CadreDeveloppement $cadreDeveloppement)
    {
		//$resultats = Resultat::whereNull('deleted_on')->get();
		$chaineLogiques = DB::table('view_cadre_logique')->get();
		$financementParResultats = CD_FinancementParResultat::where('cadre_developpement_id', $cadreDeveloppement->id)->whereNotNull('cadre_logique_id')->whereNull('deleted_on')->get();
		return view('cadreDeveloppement.financementParResultat', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'financementParResultats' => $financementParResultats,
			'chaineLogiques' => $chaineLogiques,
			'breadcrumb' => 'CadreDeveloppement > Financements par resultat',
        ]);
	}
	
	public function storeFinancementParResultat(Request $request,CadreDeveloppement $cadreDeveloppement)
    {
        
		try{
			// Validation 
			$data = $request->validate([
				'chaine_logique_ids' => 'required',
				'montant' => 'required',
			]);
			$cadreDeveloppement->financementParResultats()->create([
				'montant' => $data['montant'],
				'cadre_logique_id' => $data['chaine_logique_ids'],
			]);
			
			return redirect()->back()->with('success', 'plan de fiancement  ajoutée avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un plan de financement existe déjà pour ce resultat.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	
	public function editFinancementParResultat(Request $request, CadreDeveloppement $cadreDeveloppement, $financementId)
    {
		$chaineLogiques = DB::table('view_cadre_logique')->get();
		$chaineLogiqueNames = $cadreDeveloppement->financementParResultats->first()->cadreLogique->intitule;
		$chaineLogiqueIds = $cadreDeveloppement->financementParResultats->first()->cadreLogique->id;
		$financementParResultat = CD_FinancementParResultat::where('id',$financementId)->first();
		return view('cadreDeveloppement.editFinancementParResultat', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'financementParResultat' => $financementParResultat,
			'chaineLogiques' => $chaineLogiques,
			'chaineLogiqueNames' => $chaineLogiqueNames,
			'chaineLogiqueIds' => $chaineLogiqueIds,
			'resultatId' => $financementParResultat->cadre_logique_id,
			'montant' => $financementParResultat->montant,
			'breadcrumb' => 'CadreDeveloppement > Mise à jour Financement par catégorie de dépense',
        ]);
	}
	
	public function updateFinancementParResultat(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementParResultat $financementParResultat)
    {
		
		try{
			// Validation 
			$data = $request->validate([
				'chaine_logique_ids' => 'required',
				'montant' => 'required',
			]);
			
			$financementParResultat->update([
			'cadre_logique_id' => $data['chaine_logique_ids'],
			'montant' => $data['montant'],
		]);
        return redirect()->route('cadre_developpements.financementParResultat',['cadre_developpement' => $cadreDeveloppement->id])->with('success', 'financement par catégorie de dépense mis à jour avec succès.');
			
			
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un plan de financement existe déjà pour ce resultat.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
		
	}
	
	public function destroyFinancementParResultat(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementParResultat $financementParResultat)
    {
         $financementParResultat->deleted_on = Carbon::now();
         $financementParResultat->save();

        return redirect()->back()->with('success', 'plan de financement supprimé avec succès.');
    }
	
	public function montantMobiliseFR(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementParResultat $financementParResultat)
    {
		$montantMobilises = $financementParResultat->montantMobilises->whereNull('deleted_on')->where('statut_montant_financement_id',1);
		
		return view('cadreDeveloppement.montantMobiliseFR', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'financementParResultat' => $financementParResultat,
			'montantMobilises' => $montantMobilises,
			'breadcrumb' => 'CadreDeveloppement > Montants prévus par année',
        ]);
	}
	
	public function storeMontantMobiliseFR(Request $request,CadreDeveloppement $cadreDeveloppement,CD_FinancementParResultat $financementParResultat)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$financementParResultat->montantMobilises()->create([
				'annee'   => $data['annee'],
				'montant' => $data['montant'],
				'statut_montant_financement_id' => 1,
			]);
			
			return redirect()->back()->with('success', 'montant annuel mobilisé ajoutée avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel mobilisé existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	public function editMontantMobiliseFR(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParResultat $montantMobilise)
    {
		return view('cadreDeveloppement.editMontantMobiliseFR', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'montantMobilise' => $montantMobilise,
			'breadcrumb' => 'Reférentiel > Mise à jour catégorie dépense',
        ]);
    }

    public function updateMontantMobiliseFR(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParResultat $montantMobilise)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$montantMobilise->update($data);
			
			return redirect()->back()->with('success', 'montant annuel mobilisé modifié avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel mobilisé existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	
	public function destroyMontantMobiliseFR(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParResultat $montantMobilise)
    {
         $montantMobilise->deleted_on = Carbon::now();
         $montantMobilise->save();

        return redirect()->back()->with('success', 'montant annuel prévu supprimé avec succès.');
    }
	
	
	public function montantConsommeFR(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementParResultat $financementParResultat)
    {
		$montantConsommes = $financementParResultat->montantConsommes->whereNull('deleted_on')->where('statut_montant_financement_id',2);
		
		return view('cadreDeveloppement.montantConsommeFR', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'financementParResultat' => $financementParResultat,
			'montantConsommes' => $montantConsommes,
			'breadcrumb' => 'CadreDeveloppement > Montants consommé par année',
        ]);
	}
	
	public function storeMontantConsommeFR(Request $request,CadreDeveloppement $cadreDeveloppement,CD_FinancementParResultat $financementParResultat)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$financementParResultat->montantConsommes()->create([
				'annee'   => $data['annee'],
				'montant' => $data['montant'],
				'statut_montant_financement_id' => 2,
			]);
			
			return redirect()->back()->with('success', 'montant annuel consommé ajoutée avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel consommé existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	public function editMontantConsommeFR(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParResultat $montantConsomme)
    {
		return view('cadreDeveloppement.editMontantConsommeFR', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'montantConsomme' => $montantConsomme,
			'breadcrumb' => 'Reférentiel > Mise à jour montant consommé',
        ]);
    }

    public function updateMontantConsommeFR(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParResultat $montantConsomme)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$montantConsomme->update($data);
			
			return redirect()->back()->with('success', 'montant annuel consommé modifié avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel consommé existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	
	public function destroyMontantConsommeFR(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParResultat $montantConsomme)
    {
         $montantConsomme->deleted_on = Carbon::now();
         $montantConsomme->save();

        return redirect()->back()->with('success', 'montant annuel consommé supprimé avec succès.');
    }
	
	public function montantRechercheFR(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementParResultat $financementParResultat)
    {
		$montantRecherches = $financementParResultat->montantRecherches->whereNull('deleted_on')->where('statut_montant_financement_id',3);
		
		return view('cadreDeveloppement.montantRechercheFR', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'financementParResultat' => $financementParResultat,
			'montantRecherches' => $montantRecherches,
			'breadcrumb' => 'CadreDeveloppement > Montants recherché par année',
        ]);
	}
	
	public function storeMontantRechercheFR(Request $request,CadreDeveloppement $cadreDeveloppement,CD_FinancementParResultat $financementParResultat)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$financementParResultat->montantRecherches()->create([
				'annee'   => $data['annee'],
				'montant' => $data['montant'],
				'statut_montant_financement_id' => 3,
			]);
			
			return redirect()->back()->with('success', 'montant annuel recherché ajoutée avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel recherché existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	public function editMontantRechercheFR(Request $request, CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParResultat $montantRecherche)
    {
		return view('cadreDeveloppement.editMontantRechercheFR', [
            'cadreDeveloppement' => $cadreDeveloppement,
			'montantRecherche' => $montantRecherche,
			'breadcrumb' => 'Reférentiel > Mise à jour montant annuel recherché',
        ]);
    }

    public function updateMontantRechercheFR(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParResultat $montantRecherche)
    {
        try{
			// Validation
			$data = $request->validate([
				'annee' => 'required',
				'montant' => 'required',
			]);
			
			$montantRecherche->update($data);
			
			return redirect()->back()->with('success', 'montant annuel recherché modifié avec succès.');
		} catch (UniqueConstraintViolationException $e) {
			return redirect()->back()->with('error', 'Un montant annuel recherché existe déjà pour cette année.');
		} catch (\Throwable $e) {
			 // Autres erreurs (connexion, syntaxe, etc.)
			return redirect()->back()->with('error', 'Une erreur inattendue est survenue.');
		}
	}
	
	public function destroyMontantRechercheFR(Request $request,CadreDeveloppement $cadreDeveloppement, CD_FinancementAnnuelParResultat $montantRecherche)
    {
         $montantRecherche->deleted_on = Carbon::now();
         $montantRecherche->save();

        return redirect()->back()->with('success', 'montant annuel recherché supprimé avec succès.');
    }
	
	
	
	
	
}
