<?php

namespace App\Http\Controllers;

use App\Http\Requests\NatureFinancementStoreRequest;
use App\Http\Requests\NatureFinancementUpdateRequest;
use App\Models\NatureFinancement;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NatureFinancementController extends Controller
{
    public function index(Request $request)
    {
        $natureFinancements = NatureFinancement::whereNull('deleted_on')->get();

        return view('natureFinancement.index', [
            'natureFinancements' => $natureFinancements,
			'breadcrumb' => 'Reférentiel > Natures Financement',
        ]);
    }

    public function create(Request $request)
    {
        return view('natureFinancement.create',[
		'breadcrumb' => 'Reférentiel > Nouvelle Nature Financement',
		]);
    }

    public function store(NatureFinancementStoreRequest $request)
    {
        $natureFinancement = NatureFinancement::create($request->validated());

        return redirect()->route('nature_financements.index')->with('success', 'nature de financement créée avec succès');
       
    }

    public function show(Request $request, NatureFinancement $natureFinancement)
    {
        return view('natureFinancement.show', [
            'natureFinancement' => $natureFinancement,
			'breadcrumb' => 'Reférentiel > Natures Financement',
        ]);
    }

    public function edit(Request $request, NatureFinancement $natureFinancement)
    {
        return view('natureFinancement.edit', [
            'natureFinancement' => $natureFinancement,
			'breadcrumb' => 'Reférentiel > Mise à jour Nature Financement',
        ]);
    }

    public function update(NatureFinancementUpdateRequest $request, NatureFinancement $natureFinancement)
    {
        $natureFinancement->update($request->validated());

        return redirect()->route('nature_financements.index')->with('success', 'nature de financement modifiée avec succès');
    }

    public function destroy(Request $request, NatureFinancement $natureFinancement)
    {
        $natureFinancement->deleted_on = Carbon::now();
          $natureFinancement->save();

        return redirect()->route('nature_financements.index')->with('success', 'nature de financement supprimée avec succès');
    }
}
