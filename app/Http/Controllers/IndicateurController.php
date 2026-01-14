<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Imports\IndicateursImport;
use App\Models\Indicateur;
use App\Models\Desagregation;
use App\Models\TypeDesagregation;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\View\View;


class IndicateurController extends Controller
{
    public function showUploadForm()
    {
        return view('indicateur.upload');
    }
	
	public function upload(Request $request)
	{
		$request->validate([
			'file' => 'required|mimes:xlsx,csv,xls',
		]);

		$import = new IndicateursImport();

		Excel::import($import, $request->file('file'));

		// Récupération des indicateurs non insérés
		$failedIndicateurs = $import->getFailedRows();
		
		//print_r($failedIndicateurs);die();
		if (!empty($failedIndicateurs)) {
			return redirect()->back()->with([
				'warning' => 'Certains indicateurs n\'ont pas été importés.',
				'failed_indicateurs' => $failedIndicateurs,
			]);
		}

		return redirect()->back()->with('success', 'Tous les indicateurs ont été importés avec succès.');
	}
	
	public function showDesagregationForm(Indicateur $indicateur)
    {
		$typeDesagregations = TypeDesagregation::all()?? [];
		$desagregations = Desagregation::all();
		$desagregationsIndicateur = $indicateur->desagregations ?? [];
		
		return view('indicateur.desagregation',compact('indicateur','typeDesagregations','desagregations','desagregationsIndicateur'));
    }
	
}
