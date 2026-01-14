<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PopulationCibleProjetStoreRequest extends FormRequest
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
            'population_cible_id' => ['required', 'integer', 'exists:population_cibles,id'],
			'effectif' => ['required', 'integer'],
		];
    }
}
