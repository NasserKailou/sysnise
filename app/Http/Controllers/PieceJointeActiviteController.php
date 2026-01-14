<?php

namespace App\Http\Controllers;

use App\Http\Requests\PieceJointeActiviteStoreRequest;
use App\Http\Requests\PieceJointeActiviteUpdateRequest;
use App\Models\PieceJointeActivite;
use App\Models\Activite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PieceJointeActiviteController extends Controller
{
	
	public function store(Request $request, $activite_id)
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

        // Récupérer le activite développement
        $activite = Activite::findOrFail($activite_id);

        // Sauvegarder le fichier
        $path = $request->file('fichier')->store('pieces', 'public');

        PieceJointeActivite::create([
            'intitule' => $validated['intitule'],
            'fichier' => $path,
			'activite_id' => $activite_id,
        ]);

        return redirect()->back()->with('success', 'Pièce jointe ajoutée avec succès.');
    }

    

    public function destroy($activiteId, $pieceId)
    {
        $piece = PieceJointeActivite::findOrFail($pieceId);
		$piece->delete();
		return redirect()->back()->with('success', 'Pièce supprimée avec succès.');
		
	}
	
}
