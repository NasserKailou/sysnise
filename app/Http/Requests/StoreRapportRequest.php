<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRapportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type'        => 'required|string|in:bilan,audit,mission,aide_memoire,autre',
            'fichier'     => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:20480',
            'date_rapport' => 'nullable|date',
            'description' => 'nullable|string|max:500',
        ];
    }
}