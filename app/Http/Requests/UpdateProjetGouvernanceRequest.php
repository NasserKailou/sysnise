<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjetGouvernanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajuster selon votre logique d'autorisation (policies, gates...)
    }

    public function rules(): array
    {
        return [
            // 3.1 Pilotage
            'organe_pilotage_existe' => ['required', 'boolean'],
            'nb_sessions_prevues' => ['nullable', 'required_if:organe_pilotage_existe,1', 'integer', 'min:0'],
            'nb_sessions_tenues' => ['nullable', 'required_if:organe_pilotage_existe,1', 'integer', 'min:0'],

            'sessions' => ['nullable', 'array'],
            'sessions.*.date_session' => ['required_with:sessions', 'date'],
            'sessions.*.nb_recommandations_etablies' => ['nullable', 'integer', 'min:0'],
            'sessions.*.nb_recommandations_realisees' => ['nullable', 'integer', 'min:0'],

            // 3.2 Audits
            'comptes_audites_regulierement' => ['required', 'boolean'],
            'commentaire_audit' => ['nullable', 'string'],

            'audits' => ['nullable', 'array'],
            'audits.*.nombre_audits_realises' => ['nullable', 'integer', 'min:0'],
            'audits.*.exercice_comptable' => ['required_with:audits', 'string', 'max:20'],
            'audits.*.comptes_certifies_sans_reserves' => ['nullable', 'boolean'],
            'audits.*.nb_recommandations_etablies' => ['nullable', 'integer', 'min:0'],
            'audits.*.nb_recommandations_realisees' => ['nullable', 'integer', 'min:0'],

            // IV.1 Problèmes / solutions
            'problems' => ['nullable', 'array'],
            'problems.*.probleme_rencontre' => ['required_with:problems', 'string'],
            'problems.*.solution_proposee' => ['nullable', 'string'],

            // IV.2 Recommandations
            'recommendations' => ['nullable', 'array'],
            'recommendations.*.destinataire' => ['required_with:recommendations', 'string', 'max:255'],
            'recommendations.*.contenu' => ['required_with:recommendations', 'string'],

            // Pied de fiche
            'rempli_par' => ['nullable', 'string', 'max:255'],
            'date_remplissage' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Le champ :attribute est obligatoire.',
            'boolean' => 'Le champ :attribute doit être Oui ou Non.',
            'date' => 'Le champ :attribute doit être une date valide.',
        ];
    }
}
