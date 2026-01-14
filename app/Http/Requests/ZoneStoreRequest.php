<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZoneStoreRequest extends FormRequest
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
            'code' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            //'zone_id' => ['nullable', 'integer', 'exists:zones,id'],
            'niveau' => ['nullable', 'integer'],
        ];
    }
}
