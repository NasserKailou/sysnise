<?php

namespace App\Http\Controllers;

use App\Http\Requests\PieceJointeProduitStoreRequest;
use App\Http\Requests\PieceJointeProduitUpdateRequest;
use App\Models\PieceJointeProduit;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PieceJointeProduitController extends Controller
{
	
	public function store(Request $request, $produit_id)
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

        // Récupérer le produit développement
        $produit = Produit::findOrFail($produit_id);

        // Sauvegarder le fichier
        $path = $request->file('fichier')->store('pieces', 'public');

        PieceJointeProduit::create([
            'intitule' => $validated['intitule'],
            'fichier' => $path,
			'produit_id' => $produit_id,
        ]);

        return redirect()->back()->with('success', 'Pièce jointe ajoutée avec succès.');
    }

    

    public function destroy($produitId, $pieceId)
    {
        $piece = PieceJointeProduit::findOrFail($pieceId);
		$piece->delete();
		return redirect()->back()->with('success', 'Pièce supprimée avec succès.');
		
	}
	
}
