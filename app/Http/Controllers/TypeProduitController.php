<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeProduitStoreRequest;
use App\Http\Requests\TypeProduitUpdateRequest;
use App\Models\TypeProduit;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TypeProduitController extends Controller
{
    public function index(Request $request)
    {
        $typeProduits = TypeProduit::whereNull('deleted_on')->get();

        return view('typeProduit.index', [
            'typeProduits' => $typeProduits,
			'breadcrumb' => 'Reférentiel > Types Produit',
        ]);
    }

    public function create(Request $request)
    {
        return view('typeProduit.create',[
			'breadcrumb' => 'Reférentiel > Nouveau Type Produit',
		]);
    }

    public function store(TypeProduitStoreRequest $request)
    {
        $typeProduit = TypeProduit::create($request->validated());

        return redirect()->route('type_produits.index')->with('success', 'type produit créé avec succès');

    }

    public function show(Request $request, TypeProduit $typeProduit)
    {
        return view('typeProduit.show', [
            'typeProduit' => $typeProduit,
			'breadcrumb' => 'Reférentiel > Type Produit',
        ]);
    }

    public function edit(Request $request, TypeProduit $typeProduit)
    {
        return view('typeProduit.edit', [
            'typeProduit' => $typeProduit,
			'breadcrumb' => 'Reférentiel > Mise à jour Type Produit',
        ]);
    }

    public function update(TypeProduitUpdateRequest $request, TypeProduit $typeProduit)
    {
        $typeProduit->update($request->validated());

        return redirect()->route('type_produits.index')->with('success', 'type produit modifié avec succès');
    }

    public function destroy(Request $request, TypeProduit $typeProduit)
    {
        $typeProduit->deleted_on = Carbon::now();
          $typeProduit->save();

        return redirect()->route('type_produits.index')->with('success', 'type produit supprimé avec succès');
    }
}
