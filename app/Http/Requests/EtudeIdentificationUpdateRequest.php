<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtudeIdentificationUpdateRequest extends FormRequest
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
            'etude_id' => ['required', 'integer', 'exists:etudes,id'],
            'etude_disponible' => ['required'],
            'document_etude' => ['nullable', 'string', 'max:255'],
            'etude_envisagee' => ['nullable'],
            'source_financement_id' => ['required', 'integer', 'exists:source_financements,id'],
        ];
    }
}
