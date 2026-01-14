<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadreLogiqueStoreRequest;
use App\Http\Requests\CadreLogiqueUpdateRequest;
use App\Http\Resources\CadreLogiqueCollection;
use App\Http\Resources\CadreLogiqueResource;
use App\Models\CadreLogique;
use App\Models\OrientationCadreDeveloppement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CadreLogiqueApiController extends Controller
{
    public function index(Request $request)
    {
        $cadreLogiques = CadreLogique::all();
		return response()->json($cadreLogiques);
    }

    public function store(CadreLogiqueStoreRequest $request)
    {
		if($request->cadre_logique_id > 0)
		{
			$cadreLogique = new CadreLogique();
			$cadreLogique->intitule = $request->intitule;
			$cadreLogique->cadre_logique_id = $request->cadre_logique_id;
			$cadreLogique->save();
		}
		else
		{
			$cadreLogique = new CadreLogique();
			$cadreLogique->intitule = $request->intitule;
			$cadreLogique->save();
			$orientationCadreDeveloppement = new OrientationCadreDeveloppement();
			$orientationCadreDeveloppement->cadre_developpement_id = $request->cadre_developpement_id;
			$orientationCadreDeveloppement->cadre_logique_id = $cadreLogique->id;
			$orientationCadreDeveloppement->intitule = $cadreLogique->intitule;
			$orientationCadreDeveloppement->save();
			
		}
			
		return $cadreLogique->id;

    }

    public function show(Request $request, CadreLogique $cadreLogique)
    {
        return response()->json($cadreLogique);
    }

    public function update(CadreLogiqueUpdateRequest $request, CadreLogique $cadreLogique)
    {
        $cadreLogique = CadreLogique::find($request->id);
		$cadreLogique->intitule = $request->intitule;
		if($request->cadre_logique_id != null) 
			$cadreLogique->cadre_logique_id = $request->cadre_logique_id;
		$cadreLogique->save();
		return $cadreLogique->id;
        
    }

    public function destroy(Request $request, CadreLogique $cadreLogique)
    {
        $cadreLogique->delete();

        return response()->noContent();
    }

    /**
     * Mettre à jour le parent_id d'un cadre logique (pour le drag & drop)
     * Gère automatiquement la table orientation_cadre_developpements
     */
    public function updateParent(Request $request, $id)
    {
        $cadreLogique = CadreLogique::findOrFail($id);
        
        // Le parent_id peut être null (si déposé à la racine)
        $parentId = $request->input('parent_id');
        $cadreDeveloppementId = $request->input('cadre_developpement_id');
        
        // Valider que le cadre_developpement_id est fourni
        if (!$cadreDeveloppementId) {
            return response()->json([
                'error' => 'Le cadre_developpement_id est requis'
            ], 422);
        }
        
        // Valider que le parent_id existe si non null
        if ($parentId !== null) {
            $parentExists = CadreLogique::where('id', $parentId)->exists();
            if (!$parentExists) {
                return response()->json([
                    'error' => 'Le parent spécifié n\'existe pas'
                ], 404);
            }
            
            // Empêcher la création de cycles (un nœud ne peut pas être son propre parent)
            if ($parentId == $id) {
                return response()->json([
                    'error' => 'Un élément ne peut pas être son propre parent'
                ], 422);
            }
        }
        
        // Sauvegarder l'ancien parent_id pour la logique
        $oldParentId = $cadreLogique->cadre_logique_id;
        
        // Mettre à jour le parent_id
        $cadreLogique->cadre_logique_id = $parentId;
        $cadreLogique->save();
        
        // GESTION DE LA TABLE orientation_cadre_developpements
        
        // CAS 1: L'élément passe de premier niveau (null) vers un sous-niveau (parent != null)
        // Action: SUPPRIMER de orientation_cadre_developpements
        if ($oldParentId === null && $parentId !== null) {
            OrientationCadreDeveloppement::where('cadre_logique_id', $id)
                ->where('cadre_developpement_id', $cadreDeveloppementId)
                ->delete();
            
            $action = 'removed_from_orientation';
        }
        
        // CAS 2: L'élément passe d'un sous-niveau (parent != null) vers le premier niveau (null)
        // Action: AJOUTER dans orientation_cadre_developpements
        elseif ($oldParentId !== null && $parentId === null) {
            // Vérifier si l'entrée existe déjà (éviter les doublons)
            $exists = OrientationCadreDeveloppement::where('cadre_logique_id', $id)
                ->where('cadre_developpement_id', $cadreDeveloppementId)
                ->exists();
            
            if (!$exists) {
                OrientationCadreDeveloppement::create([
                    'cadre_logique_id' => $id,
                    'cadre_developpement_id' => $cadreDeveloppementId,
                    'intitule' => $cadreLogique->intitule
                ]);
            }
            
            $action = 'added_to_orientation';
        }
        
        // CAS 3: L'élément reste au premier niveau (null -> null) ou reste en sous-niveau (parent -> parent)
        // Action: RIEN à faire dans orientation_cadre_developpements
        else {
            $action = 'no_orientation_change';
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Parent mis à jour avec succès',
            'data' => [
                'id' => $cadreLogique->id,
                'cadre_logique_id' => $cadreLogique->cadre_logique_id,
                'old_parent_id' => $oldParentId,
                'new_parent_id' => $parentId,
                'orientation_action' => $action
            ]
        ]);
    }
}
