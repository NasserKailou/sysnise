@php
    // $projet      : instance App\Models\Projet (toujours fournie via l'URL)
    // $gouvernance   : instance ProjetGouvernance ou null (mode création)
    $isEdit = isset($gouvernance);

    $oldSessions = old('sessions', $isEdit ? $gouvernance->sessions->map(fn ($s) => [
        'date_session' => optional($s->date_session)->format('Y-m-d'),
        'nb_recommandations_etablies' => $s->nb_recommandations_etablies,
        'nb_recommandations_realisees' => $s->nb_recommandations_realisees,
    ])->toArray() : []);

    $oldAudits = old('audits', $isEdit ? $gouvernance->audits->map(fn ($a) => [
        'nombre_audits_realises' => $a->nombre_audits_realises,
        'exercice_comptable' => $a->exercice_comptable,
        'comptes_certifies_sans_reserves' => $a->comptes_certifies_sans_reserves,
        'nb_recommandations_etablies' => $a->nb_recommandations_etablies,
        'nb_recommandations_realisees' => $a->nb_recommandations_realisees,
    ])->toArray() : []);

    $oldProblems = old('problems', $isEdit ? $gouvernance->problems->map(fn ($p) => [
        'probleme_rencontre' => $p->probleme_rencontre,
        'solution_proposee' => $p->solution_proposee,
    ])->toArray() : []);

    $oldRecommendations = old('recommendations', $isEdit ? $gouvernance->recommendations->map(fn ($r) => [
        'destinataire' => $r->destinataire,
        'contenu' => $r->contenu,
    ])->toArray() : []);

    $pilotageValue = old('organe_pilotage_existe', $isEdit ? (int) $gouvernance->organe_pilotage_existe : null);
    $auditValue = old('comptes_audites_regulierement', $isEdit ? (int) $gouvernance->comptes_audites_regulierement : null);
@endphp

<form method="POST"
      action="{{ $isEdit ? route('projets.gouvernance.update', $projet) : route('projets.gouvernance.store', $projet) }}"
      x-data='gouvernanceForm(@json($oldSessions), @json($oldAudits), @json($oldProblems), @json($oldRecommendations))'>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    {{-- I. PILOTAGE ET AUDITS --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">I. Pilotage et audits</div>
        <div class="card-body">

            <h6 class="text-decoration-underline">3.1 Fonctionnement de l'organe d'orientation/pilotage</h6>

            <div class="mb-3">
                <label class="form-label d-block">Le projet dispose-t-il d'un organe d'orientation/pilotage ?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="organe_pilotage_existe" value="1" id="pilotage_oui"
                           {{ (string) $pilotageValue === '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="pilotage_oui">Oui</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="organe_pilotage_existe" value="0" id="pilotage_non"
                           {{ $pilotageValue !== null && (string) $pilotageValue === '0' ? 'checked' : '' }}>
                    <label class="form-check-label" for="pilotage_non">Non</label>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre de sessions prévues dans l'année</label>
                    <input type="number" min="0" name="nb_sessions_prevues" class="form-control"
                           value="{{ old('nb_sessions_prevues', $isEdit ? $gouvernance->nb_sessions_prevues : '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nombre de sessions tenues dans l'année</label>
                    <input type="number" min="0" name="nb_sessions_tenues" class="form-control"
                           value="{{ old('nb_sessions_tenues', $isEdit ? $gouvernance->nb_sessions_tenues : '') }}">
                </div>
            </div>

            <label class="form-label fw-semibold">Tableau n°8 : détail des sessions tenues</label>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Date de la session</th>
                    <th>Nb recommandations établies</th>
                    <th>Nb recommandations réalisées</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <template x-for="(session, index) in sessions" :key="index">
                    <tr>
                        <td>
                            <input type="date" class="form-control"
                                   :name="`sessions[${index}][date_session]`" x-model="session.date_session">
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control"
                                   :name="`sessions[${index}][nb_recommandations_etablies]`" x-model="session.nb_recommandations_etablies">
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control"
                                   :name="`sessions[${index}][nb_recommandations_realisees]`" x-model="session.nb_recommandations_realisees">
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger" @click="sessions.splice(index, 1)">Suppr.</button>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
            <button type="button" class="btn btn-sm btn-outline-primary mb-4"
                    @click="sessions.push({date_session: '', nb_recommandations_etablies: 0, nb_recommandations_realisees: 0})">
                + Ajouter une session
            </button>

            <h6 class="text-decoration-underline">3.2 Audits</h6>

            <div class="mb-3">
                <label class="form-label d-block">Les comptes du projet ont-ils fait l'objet régulièrement d'audit ?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="comptes_audites_regulierement" value="1" id="audit_oui"
                           {{ (string) $auditValue === '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="audit_oui">Oui</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="comptes_audites_regulierement" value="0" id="audit_non"
                           {{ $auditValue !== null && (string) $auditValue === '0' ? 'checked' : '' }}>
                    <label class="form-check-label" for="audit_non">Non</label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Commentaire (ex: date attendue du premier audit, rapport...)</label>
                <textarea name="commentaire_audit" class="form-control" rows="2">{{ old('commentaire_audit', $isEdit ? $gouvernance->commentaire_audit : '') }}</textarea>
            </div>

            <label class="form-label fw-semibold">Tableau n°9 : audits des comptes du projet</label>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Nb audits réalisés</th>
                    <th>Exercice comptable</th>
                    <th>Comptes certifiés sans réserves ?</th>
                    <th>Nb recommandations établies</th>
                    <th>Nb recommandations réalisées</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <template x-for="(audit, index) in audits" :key="index">
                    <tr>
                        <td>
                            <input type="number" min="0" class="form-control"
                                   :name="`audits[${index}][nombre_audits_realises]`" x-model="audit.nombre_audits_realises">
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="ex: 2025"
                                   :name="`audits[${index}][exercice_comptable]`" x-model="audit.exercice_comptable">
                        </td>
                        <td>
                            <select class="form-select" :name="`audits[${index}][comptes_certifies_sans_reserves]`" x-model="audit.comptes_certifies_sans_reserves">
                                <option value="1">Oui</option>
                                <option value="0">Non</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control"
                                   :name="`audits[${index}][nb_recommandations_etablies]`" x-model="audit.nb_recommandations_etablies">
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control"
                                   :name="`audits[${index}][nb_recommandations_realisees]`" x-model="audit.nb_recommandations_realisees">
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger" @click="audits.splice(index, 1)">Suppr.</button>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
            <button type="button" class="btn btn-sm btn-outline-primary"
                    @click="audits.push({nombre_audits_realises: 0, exercice_comptable: '', comptes_certifies_sans_reserves: '1', nb_recommandations_etablies: 0, nb_recommandations_realisees: 0})">
                + Ajouter un audit
            </button>
        </div>
    </div>

    {{-- II. PROBLEMES, SOLUTIONS ET RECOMMANDATIONS --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">II. Problèmes rencontrés, solutions proposées et recommandations</div>
        <div class="card-body">

            <h6 class="text-decoration-underline">IV.1 Problèmes rencontrés et solutions proposées</h6>

            <template x-for="(problem, index) in problems" :key="index">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <textarea class="form-control" rows="2" placeholder="Problème rencontré"
                                  :name="`problems[${index}][probleme_rencontre]`" x-model="problem.probleme_rencontre"></textarea>
                    </div>
                    <div class="col-md-5">
                        <textarea class="form-control" rows="2" placeholder="Solution proposée"
                                  :name="`problems[${index}][solution_proposee]`" x-model="problem.solution_proposee"></textarea>
                    </div>
                    <div class="col-md-1 d-flex align-items-start">
                        <button type="button" class="btn btn-sm btn-outline-danger" @click="problems.splice(index, 1)">Suppr.</button>
                    </div>
                </div>
            </template>
            <button type="button" class="btn btn-sm btn-outline-primary mb-4"
                    @click="problems.push({probleme_rencontre: '', solution_proposee: ''})">
                + Ajouter un problème
            </button>

            <h6 class="text-decoration-underline">IV.2 Recommandations</h6>

            <template x-for="(reco, index) in recommendations" :key="index">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Destinataire (ex: MAGEL, partenaires...)"
                               :name="`recommendations[${index}][destinataire]`" x-model="reco.destinataire">
                    </div>
                    <div class="col-md-7">
                        <textarea class="form-control" rows="2" placeholder="Contenu de la recommandation"
                                  :name="`recommendations[${index}][contenu]`" x-model="reco.contenu"></textarea>
                    </div>
                    <div class="col-md-1 d-flex align-items-start">
                        <button type="button" class="btn btn-sm btn-outline-danger" @click="recommendations.splice(index, 1)">Suppr.</button>
                    </div>
                </div>
            </template>
            <button type="button" class="btn btn-sm btn-outline-primary"
                    @click="recommendations.push({destinataire: '', contenu: ''})">
                + Ajouter une recommandation
            </button>
        </div>
    </div>

    {{-- Pied de fiche --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Fiche remplie par</div>
        <div class="card-body row">
            <div class="col-md-6">
                <label class="form-label">Nom et fonction du responsable</label>
                <input type="text" name="rempli_par" class="form-control"
                       value="{{ old('rempli_par', $isEdit ? $gouvernance->rempli_par : '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Date de remplissage</label>
                <input type="date" name="date_remplissage" class="form-control"
                       value="{{ old('date_remplissage', $isEdit && $gouvernance->date_remplissage ? $gouvernance->date_remplissage->format('Y-m-d') : '') }}">
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('projets.gouvernance.show', $projet) }}" class="btn btn-secondary">Annuler</a>
        <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Mettre à jour' : 'Enregistrer' }}</button>
    </div>
</form>

<script>
    function gouvernanceForm(initialSessions, initialAudits, initialProblems, initialRecommendations) {
        return {
            sessions: initialSessions.length ? initialSessions : [],
            audits: initialAudits.length ? initialAudits : [],
            problems: initialProblems.length ? initialProblems : [],
            recommendations: initialRecommendations.length ? initialRecommendations : [],
        };
    }
</script>
