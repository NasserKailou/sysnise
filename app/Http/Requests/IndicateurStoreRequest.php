<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndicateurStoreRequest extends FormRequest
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
            'code' => ['nullable', 'string', 'max:255'],
            'intitule' => ['required', 'string', 'max:255'],
            'definition' => ['nullable', 'string', 'max:255'],
            'donnees_requises' => ['nullable', 'string', 'max:255'],
            'methode_calcul' => ['nullable', 'string', 'max:255'],
            'methode_collecte' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'commentaire_limite' => ['nullable', 'string', 'max:255'],
            'niveau_desagregation' => ['nullable', 'string', 'max:255'],
            'periodicite' => ['nullable', 'string', 'max:255'],
            'unite' => ['nullable', 'string', 'max:255'],
            'echelle' => ['nullable', 'string', 'max:255'],
            'lien_avec_cadre_developpement' => ['nullable', 'string', 'max:255'],
        ];
    }
}
