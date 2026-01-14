<?php

namespace App\Http\Controllers;

//use App\Http\Requests\PieceJointeProjetStoreRequest;
//use App\Http\Requests\PieceJointeProjetUpdateRequest;
use App\Models\PieceJointeProjet;
use App\Models\Projet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PieceJointeProjetController extends Controller
{
	
	public function store(Request $request, $projet_id)
    {
        // Validation
        $validated = $request->validate([
            'intitule' => 'required',
            'fichier' => 'required',
        ]);
		
        // Récupérer le projet développement
        $projet = Projet::findOrFail($projet_id);

        // Sauvegarder le fichier
        $path = $request->file('fichier')->store('pieces', 'public');

        PieceJointeProjet::create([
            'intitule' => $validated['intitule'],
            'fichier' => $path,
			'projet_id' => $projet_id,
        ]);

        return redirect()->back()->with('success', 'Pièce jointe ajoutée avec succès.');
    }

    

    public function destroy($projetId, $pieceId)
    {
        $piece = PieceJointeProjet::findOrFail($pieceId);
		$piece->delete();
		return redirect()->back()->with('success', 'Pièce supprimée avec succès.');
		
	}
	
}
