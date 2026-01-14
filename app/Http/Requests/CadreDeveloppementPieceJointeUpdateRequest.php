<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CadreDeveloppementPieceJointeUpdateRequest extends FormRequest
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
            'cadre_developpement_id' => ['required', 'integer', 'exists:cadre_developpements,id'],
            'piece_jointe_id' => ['required', 'integer', 'exists:piece_jointes,id'],
        ];
    }
}
