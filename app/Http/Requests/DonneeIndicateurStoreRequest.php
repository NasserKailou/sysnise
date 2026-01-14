<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonneeIndicateurStoreRequest extends FormRequest
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
            'nature_donnee_id' => ['required', 'integer', 'exists:nature_donnees,id'],
            'indicateur_id' => ['required', 'integer', 'exists:indicateurs,id'],
            'zone_id' => ['required', 'integer', 'exists:zones,id'],
            'periode_id' => ['required', 'integer', 'exists:periodes,id'],
            'desagregation_id' => ['required', 'integer', 'exists:desagregations,id'],
            'source_indicateur_id' => ['required', 'integer', 'exists:source_indicateurs,id'],
            'unite_indicateur_id' => ['required', 'integer', 'exists:unite_indicateurs,id'],
            'commentaire_valeur_indicateur_id' => ['nullable', 'integer', 'exists:commentaire_valeur_indicateurs,id'],
            'valeur' => ['required', 'numeric'],
        ];
    }
}
