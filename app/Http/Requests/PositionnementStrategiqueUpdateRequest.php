<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionnementStrategiqueUpdateRequest extends FormRequest
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
            'projet_id' => ['required', 'integer', 'exists:projets,id'],
            'action_majeur_strategie_nationale' => ['nullable', 'integer', 'exists:cadre_logiques,id'],
            'action_majeur_strategie_sectorielle' => ['nullable', 'integer', 'exists:cadre_logiques,id'],
        ];
    }
}
