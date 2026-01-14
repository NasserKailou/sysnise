<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentaireValeurIndicateurStoreRequest;
use App\Http\Requests\CommentaireValeurIndicateurUpdateRequest;
use App\Models\CommentaireValeurIndicateur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentaireValeurIndicateurController extends Controller
{
    public function index(Request $request)
    {
        $commentaireValeurIndicateurs = CommentaireValeurIndicateur::all();

        return view('commentaireValeurIndicateur.index', [
            'commentaireValeurIndicateurs' => $commentaireValeurIndicateurs,
			'breadcrumb' => 'Reférentiel > Commentaires valeur',
        ]);
    }

    public function create(Request $request)
    {
        return view('commentaireValeurIndicateur.create',[
			'breadcrumb' => 'Reférentiel > Nouveau Commentaire valeur',
		]);
    }

    public function store(CommentaireValeurIndicateurStoreRequest $request)
    {
        $commentaireValeurIndicateur = CommentaireValeurIndicateur::create($request->validated());

        return redirect()->route('commentaire_valeur_indicateurs.index')->with('success', 'commentaire valeur créé avec succès');
    }

    public function show(Request $request, CommentaireValeurIndicateur $commentaireValeurIndicateur)
    {
        return view('commentaireValeurIndicateur.show', [
            'commentaireValeurIndicateur' => $commentaireValeurIndicateur,
			'breadcrumb' => 'Reférentiel > Commentaires valeur',
        ]);
    }

    public function edit(Request $request, CommentaireValeurIndicateur $commentaireValeurIndicateur)
    {
        return view('commentaireValeurIndicateur.edit', [
            'commentaireValeurIndicateur' => $commentaireValeurIndicateur,
			'breadcrumb' => 'Reférentiel > Mise à jour commentaire valeur',
        ]);
    }

    public function update(CommentaireValeurIndicateurUpdateRequest $request, CommentaireValeurIndicateur $commentaireValeurIndicateur)
    {
        $commentaireValeurIndicateur->update($request->validated());

        return redirect()->route('commentaire_valeur_indicateurs.index')->with('success', 'commentaire valeur modifié avec succès');
    }

    public function destroy(Request $request, CommentaireValeurIndicateur $commentaireValeurIndicateur)
    {
        $commentaireValeurIndicateur->delete();

        return redirect()->route('commentaire_valeur_indicateurs.index')->with('success', 'commentaire valeur supprimé avec succès');
    }
}
