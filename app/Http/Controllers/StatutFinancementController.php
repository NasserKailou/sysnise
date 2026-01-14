<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatutFinancementStoreRequest;
use App\Http\Requests\StatutFinancementUpdateRequest;
use App\Models\StatutFinancement;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatutFinancementController extends Controller
{
    public function index(Request $request)
    {
        $statutFinancements = StatutFinancement::whereNull('deleted_on')->get();

        return view('statutFinancement.index', [
            'statutFinancements' => $statutFinancements,
			'breadcrumb' => 'Reférentiel > Statuts Activité',
        ]);
    }

    public function create(Request $request)
    {
        return view('statutFinancement.create',[
			'breadcrumb' => 'Reférentiel > Nouveau Statut Activité',
		]);
    }

    public function store(StatutFinancementStoreRequest $request)
    {
        $statutFinancement = StatutFinancement::create($request->validated());

        return redirect()->route('statut_financements.index')->with('success', 'statut de financement créée avec succès');
       
    }

    public function show(Request $request, StatutFinancement $statutFinancement)
    {
        return view('statutFinancement.show', [
            'statutFinancement' => $statutFinancement,
			'breadcrumb' => 'Reférentiel > Statut Activité',
        ]);
    }

    public function edit(Request $request, StatutFinancement $statutFinancement)
    {
        return view('statutFinancement.edit', [
            'statutFinancement' => $statutFinancement,
			'breadcrumb' => 'Reférentiel > Mise à jour Statut Activité',
        ]);
    }

    public function update(StatutFinancementUpdateRequest $request, StatutFinancement $statutFinancement)
    {
        $statutFinancement->update($request->validated());

        return redirect()->route('statut_financements.index')->with('success', 'statut de financement modifiée avec succès');
    }

    public function destroy(Request $request, StatutFinancement $statutFinancement)
    {
        $statutFinancement->deleted_on = Carbon::now();
          $statutFinancement->save();

        return redirect()->route('statut_financements.index')->with('success', 'statut de financement supprimée avec succès');
    }
}
