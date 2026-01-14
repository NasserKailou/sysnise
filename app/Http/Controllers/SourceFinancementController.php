<?php

namespace App\Http\Controllers;

use App\Http\Requests\SourceFinancementStoreRequest;
use App\Http\Requests\SourceFinancementUpdateRequest;
use App\Models\SourceFinancement;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SourceFinancementController extends Controller
{
    public function index(Request $request)
    {
        $sourceFinancements = SourceFinancement::whereNull('deleted_on')->get();

        return view('sourceFinancement.index', [
            'sourceFinancements' => $sourceFinancements,
			'breadcrumb' => 'Reférentiel > Sources Financement',
        ]);
    }

    public function create(Request $request)
    {
        return view('sourceFinancement.create',[
			'breadcrumb' => 'Reférentiel > Nouvelle Source Financement',
		]);
    }

    public function store(SourceFinancementStoreRequest $request)
    {
        $sourceFinancement = SourceFinancement::create($request->validated());

        return redirect()->route('source_financements.index')->with('success', 'source de financement créée avec succès');
       
    }

    public function show(Request $request, SourceFinancement $sourceFinancement)
    {
        return view('sourceFinancement.show', [
            'sourceFinancement' => $sourceFinancement,
			'breadcrumb' => 'Reférentiel > Source Financement',
        ]);
    }

    public function edit(Request $request, SourceFinancement $sourceFinancement)
    {
        return view('sourceFinancement.edit', [
            'sourceFinancement' => $sourceFinancement,
			'breadcrumb' => 'Reférentiel > Mise à jour Source Financement',
        ]);
    }

    public function update(SourceFinancementUpdateRequest $request, SourceFinancement $sourceFinancement)
    {
        $sourceFinancement->update($request->validated());

        return redirect()->route('source_financements.index')->with('success', 'source de financement modifiée avec succès');
    }

    public function destroy(Request $request, SourceFinancement $sourceFinancement)
    {
        $sourceFinancement->deleted_on = Carbon::now();
          $sourceFinancement->save();

        return redirect()->route('source_financements.index')->with('success', 'source de financement supprimée avec succès');
    }
}
