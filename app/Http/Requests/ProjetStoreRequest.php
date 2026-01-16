<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjetStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'sigle' => ['required', 'string', 'max:255'],
            'intitule' => ['required', 'string', 'max:255'],
            'priorite_id' => ['nullable', 'integer', 'exists:priorites,id'],
            'secteur_id' => ['nullable', 'integer', 'exists:secteurs,id'],
            'institution_tutelle_id' => ['nullable', 'integer', 'exists:institution_tutelles,id'],
            'direction_agence' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
            'cout' => ['nullable', 'numeric'],
			'cout_devise' => ['nullable', 'numeric'],
			'devise_id' => ['nullable', 'integer', 'exists:devises,id'],
            'annee_demarrage' => ['nullable', 'integer'],
            'date_debut_prevue' => ['nullable', 'date'],
            'date_fin_prevue' => ['nullable', 'date'],
			'date_debut_effective' => ['nullable', 'date'],
            'date_fin_effective' => ['nullable', 'date'],
            'duree' => ['nullable', 'integer'],
			'statut_projet_id' => ['nullable', 'integer', 'exists:statut_projets,id'],
			'projet_id' => ['nullable', 'string'],
			'date_approbation' => ['nullable', 'date'],
			'date_signature' => ['nullable', 'date'],
			'date_mise_en_vigueur' => ['nullable', 'date'],
			'date_demarrage_effectif' => ['nullable', 'date'],
			'Partenaires' => ['nullable', 'string'],
			'periode_prorogation' => ['nullable', 'string'],
			'duree_prorogation'=> ['nullable', 'string'],
			
        ];
    }
}
