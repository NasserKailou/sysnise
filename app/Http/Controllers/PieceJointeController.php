<?php

namespace App\Http\Controllers;

use App\Http\Requests\PieceJointeStoreRequest;
use App\Http\Requests\PieceJointeUpdateRequest;
use App\Models\PieceJointe;
use App\Models\CadreDeveloppement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PieceJointeController extends Controller
{
	
	public function store(Request $request, $cadre_developpement_id)
    {
        // Validation
        $validated = $request->validate([
            'intitule' => 'required',
            'fichier' => 'required',
        ]);
		
		/*$validated = $request->validate([
            'intitule' => 'required|string|max:255',
            'fichier' => 'required|file|mimes:pdf,jpg,png,docx',
        ]);*/

        // Récupérer le cadre développement
        $cadre = CadreDeveloppement::findOrFail($cadre_developpement_id);

        // Sauvegarder le fichier
        $path = $request->file('fichier')->store('pieces', 'public');

        PieceJointe::create([
            'intitule' => $validated['intitule'],
            'fichier' => $path,
			'cadre_developpement_id' => $cadre_developpement_id,
        ]);

        return redirect()->back()->with('success', 'Pièce jointe ajoutée avec succès.');
    }

    

    public function destroy($cadreId, $pieceId)
    {
        $piece = PieceJointe::findOrFail($pieceId);
		$piece->delete();
		return redirect()->back()->with('success', 'Pièce supprimée avec succès.');
	}
	
}
