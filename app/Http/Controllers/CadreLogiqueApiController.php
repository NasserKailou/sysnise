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
     */
    public function updateParent(Request $request, $id)
    {
        $cadreLogique = CadreLogique::findOrFail($id);
        
        // Le parent_id peut être null (si déposé à la racine)
        $parentId = $request->input('parent_id');
        
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
        
        $cadreLogique->cadre_logique_id = $parentId;
        $cadreLogique->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Parent mis à jour avec succès',
            'data' => [
                'id' => $cadreLogique->id,
                'cadre_logique_id' => $cadreLogique->cadre_logique_id
            ]
        ]);
    }
}
