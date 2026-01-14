<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorieDepenseStoreRequest extends FormRequest
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
            'intitule' => ['required', 'string', 'max:255', 'unique:categorie_depenses,intitule'],
        ];
    }
}
