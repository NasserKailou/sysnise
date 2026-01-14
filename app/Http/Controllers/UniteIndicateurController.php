<?php

namespace App\Http\Controllers;

use App\Http\Requests\UniteIndicateurStoreRequest;
use App\Http\Requests\UniteIndicateurUpdateRequest;
use App\Models\UniteIndicateur;
use App\Imports\UniteIndicateursImport;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class UniteIndicateurController extends Controller
{
    public function index(Request $request)
    {
        $uniteIndicateurs = UniteIndicateur::whereNull('deleted_on')->get();

        return view('uniteIndicateur.index', [
            'uniteIndicateurs' => $uniteIndicateurs,
			'breadcrumb' => 'Reférentiel > Unités Indicateur',
        ]);
    }

    public function create(Request $request)
    {
        return view('uniteIndicateur.create',[
			'breadcrumb' => 'Reférentiel > Nouvelle Unité Indicateur',
		]);
    }

    public function store(UniteIndicateurStoreRequest $request)
    {
        $uniteIndicateur = UniteIndicateur::create($request->validated());

        return redirect()->route('unite_indicateurs.index')->with('success', 'unité créée avec succès');
    }

    public function show(Request $request, UniteIndicateur $uniteIndicateur)
    {
        return view('uniteIndicateur.show', [
            'uniteIndicateur' => $uniteIndicateur,
			'breadcrumb' => 'Reférentiel > Unité Indicateur',
        ]);
    }

    public function edit(Request $request, UniteIndicateur $uniteIndicateur)
    {
        return view('uniteIndicateur.edit', [
            'uniteIndicateur' => $uniteIndicateur,
			'breadcrumb' => 'Reférentiel > Mise à jour Unité Indicateur',
        ]);
    }

    public function update(UniteIndicateurUpdateRequest $request, UniteIndicateur $uniteIndicateur)
    {
        $uniteIndicateur->update($request->validated());

        return redirect()->route('unite_indicateurs.index')->with('success', 'unité modifiée avec succès');
    }

    public function destroy(Request $request, UniteIndicateur $uniteIndicateur)
    {
       $uniteIndicateur->deleted_on = Carbon::now();
          $uniteIndicateur->save();

        return redirect()->route('unite_indicateurs.index')->with('success', 'unité supprimée avec succès');
    }
	
	public function showUploadForm()
    {
        return view('uniteIndicateur.upload');
    }
	
	public function upload(Request $request)
	{
		$request->validate([
			'file' => 'required|mimes:xlsx,csv,xls',
		]);

		$import = new UniteIndicateursImport();

		Excel::import($import, $request->file('file'));

		// Récupération des indicateurs non insérés
		$failedUnites = $import->getFailedRows();
		
		
		if (!empty($failedUnites)) {
			return redirect()->back()->with([
				'warning' => 'Certaines unités n\'ont pas été importées.',
				'failed_unites' => $failedUnites,
			]);
		}

		return redirect()->back()->with('success', 'Tous les unités ont été importées avec succès.');
	}
}
