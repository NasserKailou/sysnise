<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjetGeneralRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'dispose_organe_pilotage' => 'nullable|boolean',
            'a_audit_regulier'         => 'nullable|boolean',
            'problemes_rencontres'     => 'nullable|string',
            'solutions_proposees'      => 'nullable|string',
            'recommandations'          => 'nullable|string',
            'rapport_rempli_par'       => 'nullable|string|max:255',
            'rapport_date_remplissage' => 'nullable|date',
        ];
    }
}