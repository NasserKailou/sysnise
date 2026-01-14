<?php

namespace App\Http\Controllers;

use App\Http\Requests\SourceIndicateurStoreRequest;
use App\Http\Requests\SourceIndicateurUpdateRequest;
use App\Models\SourceIndicateur;
use App\Imports\SourceIndicateursImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class SourceIndicateurController extends Controller
{
    public function index(Request $request)
    {
        $sourceIndicateurs = SourceIndicateur::all();

        return view('sourceIndicateur.index', [
            'sourceIndicateurs' => $sourceIndicateurs,
			'breadcrumb' => 'Reférentiel > Sources Indicateur',
        ]);
    }

    public function create(Request $request)
    {
        return view('sourceIndicateur.create',[
			'breadcrumb' => 'Reférentiel > Nouvelle Source Indicateur',
		]);
    }

    public function store(SourceIndicateurStoreRequest $request)
    {
        $sourceIndicateur = SourceIndicateur::create($request->validated());

        //$request->session()->flash('sourceIndicateur.id', $sourceIndicateur->id);
		
		return redirect()->route('source_indicateurs.index')->with('success', 'source de donnée créée avec succès');

    }

    public function show(Request $request, SourceIndicateur $sourceIndicateur)
    {
        return view('sourceIndicateur.show', [
            'sourceIndicateur' => $sourceIndicateur,
			'breadcrumb' => 'Reférentiel > Source Indicateur',
        ]);
    }

    public function edit(Request $request, SourceIndicateur $sourceIndicateur)
    {
        return view('sourceIndicateur.edit', [
            'sourceIndicateur' => $sourceIndicateur,
			'breadcrumb' => 'Reférentiel > Mise à jour Source Indicateur',
        ]);
    }

    public function update(SourceIndicateurUpdateRequest $request, SourceIndicateur $sourceIndicateur)
    {
        $sourceIndicateur->update($request->validated());

        return redirect()->route('source_indicateurs.index')->with('success', 'source de donnée modifiée avec succès');

    }

    public function destroy(Request $request, SourceIndicateur $sourceIndicateur)
    {
        $sourceIndicateur->delete();

        return redirect()->route('source_indicateurs.index')->with('success', 'source de donnée supprimée avec succès');

    }
	
	public function showUploadForm()
    {
        return view('sourceIndicateur.upload');
    }
	
	public function upload(Request $request)
	{
		$request->validate([
			'file' => 'required|mimes:xlsx,csv,xls',
		]);

		$import = new SourceIndicateursImport();

		Excel::import($import, $request->file('file'));

		// Récupération des indicateurs non insérés
		$failedSources = $import->getFailedRows();
		
		//print_r($failedSources);die();
		if (!empty($failedSources)) {
			return redirect()->back()->with([
				'warning' => 'Certaines sources n\'ont pas été importées.',
				'failed_sources' => $failedSources,
			]);
		}

		return redirect()->back()->with('success', 'Tous les sources ont été importées avec succès.');
	}
}
