<?php

namespace App\Http\Controllers;
use App\Models\CadreDeveloppement;
use App\Models\CadreLogique;
use App\Models\Indicateur;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CadreLogiqueImport;
use Session;

class CadreLogiqueController extends Controller
{
    public function index($cadre_developpement_id)
    {

        //$cadreDeveloppement = CadreDeveloppement::findOrFail($cadre_developpement_id);

        $cadreDeveloppement = CadreDeveloppement::find($cadre_developpement_id);

        if (
            !$cadreDeveloppement || $cadreDeveloppement->institution_tutelle_id !== Auth::user()->institution_tutelle_id
        ) {
            Session::flash('error', 'Accès non autorisé');
            return redirect()->back();//->with('error', 'Accès non autorisé');
        }

        $indicateurs = Indicateur::all();
        $cadre_logiques = CadreLogique::getHierarchyByCadreDeveloppement($cadre_developpement_id);
        $breadcrumb = 'Cadres stratégiques > Cadre de Résultat';
        return view('cadreLogique.index', compact('breadcrumb', 'cadreDeveloppement', 'cadre_logiques', 'indicateurs'));
    }

    public function showUploadForm($cadre_developpement_id)
    {
        $cadreDeveloppement = CadreDeveloppement::findOrFail($cadre_developpement_id);

        return view('cadreLogique.upload', compact('cadreDeveloppement', ));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,xls',
            'cadre_developpement_id' => 'required|integer|exists:cadre_developpements,id',
        ]);

        Excel::import(
            new CadreLogiqueImport($request->cadre_developpement_id),
            $request->file('fichier')
        );

        return back()->with('success', 'Import du cadre logique effectué avec succès.');
    }


}
