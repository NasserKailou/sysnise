<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviseStoreRequest;
use App\Http\Requests\DeviseUpdateRequest;
use App\Models\Devise;
use App\Imports\DevisesImport;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class DeviseController extends Controller
{
    public function index(Request $request)
    {
        $devises = Devise::whereNull('deleted_on')->get();

        return view('devise.index', [
            'devises' => $devises,
			'breadcrumb' => 'Reférentiel > Périodes',
        ]);
    }

    public function create(Request $request)
    {
	return view('devise.create',[
		'breadcrumb' => 'Reférentiel > Nouvelle Période',
		]);
    }

    public function store(DeviseStoreRequest $request)
    {
        $devise = Devise::create($request->validated());

        return redirect()->route('devises.index')->with('success', 'période créée avec succès');
       
    }

    public function show(Request $request, Devise $devise)
    {
        return view('devise.show', [
            'devise' => $devise,
			'breadcrumb' => 'Reférentiel > Périodes',
        ]);
    }

    public function edit(Request $request, Devise $devise)
    {
        return view('devise.edit', [
            'devise' => $devise,
			'breadcrumb' => 'Reférentiel > Mise à jour Période',
        ]);
    }

    public function update(DeviseUpdateRequest $request, Devise $devise)
    {
        $devise->update($request->validated());

        return redirect()->route('devises.index')->with('success', 'période modifiée avec succès');
    }

    public function destroy(Request $request, Devise $devise)
    {
        $devise->deleted_on = Carbon::now();
          $devise->save();

        return redirect()->route('devises.index')->with('success', 'période supprimée avec succès');
    }
	
	public function showUploadForm()
    {
        return view('devise.upload');
    }
	
	public function upload(Request $request)
	{
		$request->validate([
			'file' => 'required|mimes:xlsx,csv,xls',
		]);

		$import = new DevisesImport();

		Excel::import($import, $request->file('file'));

		// Récupération des périodes non insérés
		$failedDevises = $import->getFailedRows();
		
		
		if (!empty($failedUnites)) {
			return redirect()->back()->with([
				'warning' => 'Certaines unités n\'ont pas été importées.',
				'failed_unites' => $failedUnites,
			]);
		}

		return redirect()->back()->with('success', 'Tous les unités ont été importées avec succès.');
	}
}
