<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatutProduitStoreRequest;
use App\Http\Requests\StatutProduitUpdateRequest;
use App\Models\StatutProduit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatutProduitController extends Controller
{
    public function index(Request $request)
    {
        $statutProduits = StatutProduit::all();

        return view('statutProduit.index', [
            'statutProduits' => $statutProduits,
			'breadcrumb' => 'Reférentiel > Statuts Produit',
        ]);
    }

    public function create(Request $request)
    {
        return view('statutProduit.create',[
			'breadcrumb' => 'Reférentiel > Nouveau Statut Produit',
		]);
    }

    public function store(StatutProduitStoreRequest $request)
    {
        $statutProduit = StatutProduit::create($request->validated());

        return redirect()->route('statut_produits.index')->with('success', 'statut produit créé avec succès');

    }

    public function show(Request $request, StatutProduit $statutProduit)
    {
        return view('statutProduit.show', [
            'statutProduit' => $statutProduit,
			'breadcrumb' => 'Reférentiel > Statut Produit',
        ]);
    }

    public function edit(Request $request, StatutProduit $statutProduit)
    {
        return view('statutProduit.edit', [
            'statutProduit' => $statutProduit,
			'breadcrumb' => 'Reférentiel > Mise à jour Statut Produit',
        ]);
    }

    public function update(StatutProduitUpdateRequest $request, StatutProduit $statutProduit)
    {
        $statutProduit->update($request->validated());

        return redirect()->route('statut_produits.index')->with('success', 'statut produit modifié avec succès');
    }

    public function destroy(Request $request, StatutProduit $statutProduit)
    {
        $statutProduit->delete();

        return redirect()->route('statut_produits.index')->with('success', 'statut produit supprimé avec succès');
    }
}
