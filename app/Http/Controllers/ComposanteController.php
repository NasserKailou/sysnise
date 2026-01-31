<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Projet;
use App\Models\Composante;
use App\Models\CadreDeveloppement;
use App\Models\CadreLogique;
use App\Models\Indicateur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ComposanteImport;

class ComposanteController extends Controller
{
    public function index($projet_id)
    {
        $projet = Projet::findOrFail($projet_id);
		$produits = CadreLogique::getProduitsByCadreDeveloppement($projet->cadreDeveloppement->id);
		/*$produits = DB::select(
            'SELECT * FROM get_cadre_logique_feuilles(?)',
            [9]
        );*/
		$composantes = Composante::where('projet_id',$projet_id)->get();
		$breadcrumb = 'Projets >Composantes';
        return view('composante.index', compact('breadcrumb','projet', 'composantes','produits'));
    }
	
	public function showUploadForm($projet_id)
    {
        $projet = Projet::findOrFail($projet_id);
		
        return view('composante.upload', compact('projet',));
    }
	
	public function upload(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,xls',
            'projet_id' => 'required|integer|exists:projets,id',
        ]);

        Excel::import(
            new ComposanteImport($request->projet_id),
            $request->file('fichier')
        );
	
        return back()->with('success', 'Import des composantes projet effectué avec succès.');
    }
	

}
