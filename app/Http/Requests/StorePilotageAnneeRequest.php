<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePilotageAnneeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'annee'                       => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'nb_sessions_prevues'          => 'nullable|integer|min:0',
            'nb_sessions_tenues'            => 'nullable|integer|min:0',
            'nb_recommandations_formulees' => 'nullable|integer|min:0',
            'nb_recommandations_mises_oeuvre' => 'nullable|integer|min:0',
            'sessions'                     => 'nullable|array',
            'sessions.*'                    => 'nullable|date',
        ];
    }
}