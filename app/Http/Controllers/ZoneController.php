<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZoneStoreRequest;
use App\Http\Requests\ZoneUpdateRequest;
use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ZonesImport;

class ZoneController extends Controller
{
    public function index(Request $request)
    {
        $zones = Zone::all();

        return view('zone.index', [
            'zones' => $zones,
			'breadcrumb' => 'Reférentiel > Zones',
        ]);
    }
	
	public function showUploadForm()
    {
        return view('zone.upload');
    }
	
	public function upload(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,xls',
            
		]);

        Excel::import(
            new ZonesImport(),
            $request->file('fichier')
        );

        return back()->with('success', 'Import des zones effectué avec succès.');
    }

    
}
