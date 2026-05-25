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
            'statut_projet_id' => ['nullable', 'integer', 'exists:statut_projets,id'],
			'priorite_id' => ['nullable', 'integer', 'exists:priorites,id'],
            'institution_tutelle_id' => ['nullable', 'integer', 'exists:institution_tutelles,id'],
            'contact' => ['nullable', 'string', 'max:255'],
            'annee_demarrage' => ['nullable', 'integer'],
			'date_debut_prevue' => ['nullable', 'date'],
            'date_fin_prevue' => ['nullable', 'date'],
			'date_approbation' => ['nullable', 'date'],
			'date_signature' => ['nullable', 'date'],
			'date_mise_en_vigueur' => ['nullable', 'date'],
			'date_debut_effective' => ['nullable', 'date'],
			'date_fin_effective' => ['nullable', 'date'],
			'duree' => ['nullable', 'integer'],
			'cout' => ['nullable', 'numeric'],
			'cout_devise' => ['nullable', 'numeric'],
			'devise_id' => ['nullable', 'integer', 'exists:devises,id'],
            'date_prorogation' => ['nullable', 'date'],
			'date_cloture_prorogation' => ['nullable', 'date'],
			'duree_prorogation'=> ['nullable', 'integer'],
			'projet_id' => ['nullable', 'string'],
			
        ];
    }
}
