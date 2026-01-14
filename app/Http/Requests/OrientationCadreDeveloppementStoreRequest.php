<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrientationCadreDeveloppementStoreRequest extends FormRequest
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
            'cadre_developpement_id' => ['required', 'integer', 'exists:cadre_developpements,id'],
            'cadre_logique_id' => ['required', 'integer', 'exists:cadre_logiques,id'],
        ];
    }
}
