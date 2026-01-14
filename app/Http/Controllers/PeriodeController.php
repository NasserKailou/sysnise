<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodeStoreRequest;
use App\Http\Requests\PeriodeUpdateRequest;
use App\Models\Periode;
use App\Imports\PeriodesImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PeriodeController extends Controller
{
    public function index(Request $request)
    {
        $periodes = Periode::all();

        return view('periode.index', [
            'periodes' => $periodes,
			'breadcrumb' => 'Reférentiel > Périodes',
        ]);
    }

    public function create(Request $request)
    {
	return view('periode.create',[
		'breadcrumb' => 'Reférentiel > Nouvelle Période',
		]);
    }

    public function store(PeriodeStoreRequest $request)
    {
        $periode = Periode::create($request->validated());

        return redirect()->route('periodes.index')->with('success', 'période créée avec succès');
       
    }

    public function show(Request $request, Periode $periode)
    {
        return view('periode.show', [
            'periode' => $periode,
			'breadcrumb' => 'Reférentiel > Périodes',
        ]);
    }

    public function edit(Request $request, Periode $periode)
    {
        return view('periode.edit', [
            'periode' => $periode,
			'breadcrumb' => 'Reférentiel > Mise à jour Période',
        ]);
    }

    public function update(PeriodeUpdateRequest $request, Periode $periode)
    {
        $periode->update($request->validated());

        return redirect()->route('periodes.index')->with('success', 'période modifiée avec succès');
    }

    public function destroy(Request $request, Periode $periode)
    {
        $periode->delete();

        return redirect()->route('periodes.index')->with('success', 'période supprimée avec succès');
    }
	
	public function showUploadForm()
    {
        return view('periode.upload');
    }
	
	public function upload(Request $request)
	{
		$request->validate([
			'file' => 'required|mimes:xlsx,csv,xls',
		]);

		$import = new PeriodesImport();

		Excel::import($import, $request->file('file'));

		// Récupération des périodes non insérés
		$failedPeriodes = $import->getFailedRows();
		
		
		if (!empty($failedUnites)) {
			return redirect()->back()->with([
				'warning' => 'Certaines unités n\'ont pas été importées.',
				'failed_unites' => $failedUnites,
			]);
		}

		return redirect()->back()->with('success', 'Tous les unités ont été importées avec succès.');
	}
}
