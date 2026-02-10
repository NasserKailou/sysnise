<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CadreDeveloppementUpdateRequest extends FormRequest
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
            'intitule' => ['required', 'string', 'max:255'],
            'structure_responsable' => ['nullable', 'string', 'max:255'],
            'annee_debut' => ['nullable', 'string', 'max:255'],
            'annee_fin' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
			'cout_total_financement' => ['nullable', 'string'],
            'cadre_developpement_id' => ['nullable', 'integer', 'exists:cadre_developpements,id'],
        ];
    }
}
