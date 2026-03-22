<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuditExerciceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'exercice'                      => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'comptes_certifies'              => 'nullable|boolean',
            'nb_recommandations_formulees'   => 'nullable|integer|min:0',
            'nb_recommandations_mises_oeuvre' => 'nullable|integer|min:0',
        ];
    }
}