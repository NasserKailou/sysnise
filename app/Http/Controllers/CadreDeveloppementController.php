<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCadreDeveloppementInstitutionRequest;
use App\Http\Requests\StoreCadreDeveloppementUserRequest;
use App\Models\CadreDeveloppementInstitution;
use App\Models\CadreDeveloppementUser;
use App\Models\InstitutionTutelle;
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
}
