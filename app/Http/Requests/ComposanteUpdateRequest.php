<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComposanteUpdateRequest extends FormRequest
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
	 //'composante_id' => ['nullable', 'integer', 'exists:composantes,id'],
    public function rules(): array
    {
        return [
            'intitule' => ['required', 'string', 'max:255'],
            'niveau' => ['nullable', 'integer'],
            
        ];
    }
}
