<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActiviteStoreRequest extends FormRequest
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
            'intitule' => ['nullable', 'string'],
			'annee_debut_prevu' => ['nullable', 'string'],
			'annee_fin_prevu' => ['nullable', 'string'],
			'duree_travaux' => ['nullable', 'string'],
			'cout_prevu' => ['nullable', 'string'],
			'responsable' => ['nullable', 'string'],
			'contact_responsable' => ['nullable', 'string'],
			'statut_activite_id' => ['nullable', 'string'],
			'type_activite_id' => ['nullable', 'string'],
			'description'=> ['nullable', 'string'] ,
			'date_debut_realisation' => ['nullable', 'string'],
			'date_fin_realisation' => ['nullable', 'string'],
			'cout_realisation' => ['nullable', 'string'],
			'activite_id' => ['nullable', 'string'],
        ];
    }
}
