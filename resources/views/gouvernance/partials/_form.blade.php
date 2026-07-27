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
        'exercice_comptable' => $a->exercice_comptable,
        'comptes_certifies_sans_reserves' => (int) $a->comptes_certifies_sans_reserves,
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

            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label fw-semibold mb-0">Tableau n°8 : détail des sessions tenues</label>
                <button type="button" class="btn btn-sm btn-outline-primary"
                        @click="openSessionModal(); showModal('sessionModal')">
                    + Ajouter une session
                </button>
            </div>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Date de la session</th>
                    <th>Nb recommandations établies</th>
                    <th>Nb recommandations réalisées</th>
                    <th style="width: 140px;"></th>
                </tr>
                </thead>
                <tbody>
                <template x-if="sessions.length === 0">
                    <tr><td colspan="4" class="text-muted">Aucune session ajoutée.</td></tr>
                </template>
                <template x-for="(session, index) in sessions" :key="index">
                    <tr>
                        <td x-text="session.date_session"></td>
                        <td x-text="session.nb_recommandations_etablies"></td>
                        <td x-text="session.nb_recommandations_realisees"></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                    @click="openSessionModal(index); showModal('sessionModal')">Modifier</button>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    @click="sessions.splice(index, 1)">Suppr.</button>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>

            {{-- Champs cachés resynchronisés à chaque changement de "sessions" --}}
            <template x-for="(session, index) in sessions" :key="'hidden-session-' + index">
                <span>
                    <input type="hidden" :name="`sessions[${index}][date_session]`" :value="session.date_session">
                    <input type="hidden" :name="`sessions[${index}][nb_recommandations_etablies]`" :value="session.nb_recommandations_etablies">
                    <input type="hidden" :name="`sessions[${index}][nb_recommandations_realisees]`" :value="session.nb_recommandations_realisees">
                </span>
            </template>

            <h6 class="text-decoration-underline mt-4">3.2 Audits</h6>

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

            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label fw-semibold mb-0">Tableau n°9 : audits des comptes du projet</label>
                <button type="button" class="btn btn-sm btn-outline-primary"
                        @click="openAuditModal(); showModal('auditModal')">
                    + Ajouter un audit
                </button>
            </div>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Exercice comptable</th>
                    <th>Comptes certifiés sans réserves ?</th>
                    <th>Nb recommandations établies</th>
                    <th>Nb recommandations réalisées</th>
                    <th style="width: 140px;"></th>
                </tr>
                </thead>
                <tbody>
                <template x-if="audits.length === 0">
                    <tr><td colspan="5" class="text-muted">Aucun audit ajouté.</td></tr>
                </template>
                <template x-for="(audit, index) in audits" :key="index">
                    <tr>
                        <td x-text="audit.exercice_comptable"></td>
                        <td x-text="Number(audit.comptes_certifies_sans_reserves) === 1 ? 'Oui' : 'Non'"></td>
                        <td x-text="audit.nb_recommandations_etablies"></td>
                        <td x-text="audit.nb_recommandations_realisees"></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                    @click="openAuditModal(index); showModal('auditModal')">Modifier</button>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    @click="audits.splice(index, 1)">Suppr.</button>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>

            <template x-for="(audit, index) in audits" :key="'hidden-audit-' + index">
                <span>
                    <input type="hidden" :name="`audits[${index}][exercice_comptable]`" :value="audit.exercice_comptable">
                    <input type="hidden" :name="`audits[${index}][comptes_certifies_sans_reserves]`" :value="audit.comptes_certifies_sans_reserves">
                    <input type="hidden" :name="`audits[${index}][nb_recommandations_etablies]`" :value="audit.nb_recommandations_etablies">
                    <input type="hidden" :name="`audits[${index}][nb_recommandations_realisees]`" :value="audit.nb_recommandations_realisees">
                </span>
            </template>
        </div>
    </div>

    {{-- II. PROBLEMES, SOLUTIONS ET RECOMMANDATIONS --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">II. Problèmes rencontrés, solutions proposées et recommandations</div>
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="text-decoration-underline mb-0">IV.1 Problèmes rencontrés et solutions proposées</h6>
                <button type="button" class="btn btn-sm btn-outline-primary"
                        @click="openProblemModal(); showModal('problemModal')">
                    + Ajouter un problème
                </button>
            </div>

            <template x-if="problems.length === 0">
                <p class="text-muted">Aucun problème ajouté.</p>
            </template>
            <template x-for="(problem, index) in problems" :key="index">
                <div class="border rounded p-2 mb-2">
                    <p class="mb-1"><strong>Problème :</strong> <span x-text="problem.probleme_rencontre"></span></p>
                    <p class="mb-2"><strong>Solution :</strong> <span x-text="problem.solution_proposee || '-'"></span></p>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                            @click="openProblemModal(index); showModal('problemModal')">Modifier</button>
                    <button type="button" class="btn btn-sm btn-outline-danger"
                            @click="problems.splice(index, 1)">Suppr.</button>
                </div>
            </template>

            <template x-for="(problem, index) in problems" :key="'hidden-problem-' + index">
                <span>
                    <input type="hidden" :name="`problems[${index}][probleme_rencontre]`" :value="problem.probleme_rencontre">
                    <input type="hidden" :name="`problems[${index}][solution_proposee]`" :value="problem.solution_proposee">
                </span>
            </template>

            <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
                <h6 class="text-decoration-underline mb-0">IV.2 Recommandations</h6>
                <button type="button" class="btn btn-sm btn-outline-primary"
                        @click="openRecommendationModal(); showModal('recommendationModal')">
                    + Ajouter une recommandation
                </button>
            </div>

            <template x-if="recommendations.length === 0">
                <p class="text-muted">Aucune recommandation ajoutée.</p>
            </template>
            <template x-for="(reco, index) in recommendations" :key="index">
                <div class="border rounded p-2 mb-2">
                    <p class="mb-1"><strong>Destinataire :</strong> <span x-text="reco.destinataire"></span></p>
                    <p class="mb-2"><strong>Contenu :</strong> <span x-text="reco.contenu"></span></p>
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                            @click="openRecommendationModal(index); showModal('recommendationModal')">Modifier</button>
                    <button type="button" class="btn btn-sm btn-outline-danger"
                            @click="recommendations.splice(index, 1)">Suppr.</button>
                </div>
            </template>

            <template x-for="(reco, index) in recommendations" :key="'hidden-reco-' + index">
                <span>
                    <input type="hidden" :name="`recommendations[${index}][destinataire]`" :value="reco.destinataire">
                    <input type="hidden" :name="`recommendations[${index}][contenu]`" :value="reco.contenu">
                </span>
            </template>
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

    {{-- ============================================================ --}}
    {{-- MODALE : session de pilotage (tableau n°8) --}}
    {{-- ============================================================ --}}
    <div class="modal fade" id="sessionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" x-text="sessionEditIndex === null ? 'Ajouter une session' : 'Modifier la session'"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Date de la session</label>
                        <input type="date" class="form-control" x-model="sessionForm.date_session">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de recommandations établies</label>
                        <input type="number" min="0" class="form-control" x-model.number="sessionForm.nb_recommandations_etablies">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de recommandations réalisées</label>
                        <input type="number" min="0" class="form-control" x-model.number="sessionForm.nb_recommandations_realisees">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" @click="if (saveSession()) hideModal('sessionModal')">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MODALE : audit des comptes (tableau n°9) --}}
    {{-- ============================================================ --}}
    <div class="modal fade" id="auditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" x-text="auditEditIndex === null ? 'Ajouter un audit' : 'Modifier l\'audit'"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Exercice comptable</label>
                        <input type="text" class="form-control" placeholder="ex: 2025" x-model="auditForm.exercice_comptable">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comptes certifiés sans réserves ?</label>
                        <select class="form-select" x-model="auditForm.comptes_certifies_sans_reserves">
                            <option value="1">Oui</option>
                            <option value="0">Non</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de recommandations établies</label>
                        <input type="number" min="0" class="form-control" x-model.number="auditForm.nb_recommandations_etablies">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de recommandations réalisées</label>
                        <input type="number" min="0" class="form-control" x-model.number="auditForm.nb_recommandations_realisees">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" @click="if (saveAudit()) hideModal('auditModal')">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MODALE : problème rencontré / solution proposée (IV.1) --}}
    {{-- ============================================================ --}}
    <div class="modal fade" id="problemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" x-text="problemEditIndex === null ? 'Ajouter un problème' : 'Modifier le problème'"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Problème rencontré</label>
                        <textarea class="form-control" rows="3" x-model="problemForm.probleme_rencontre"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Solution proposée</label>
                        <textarea class="form-control" rows="3" x-model="problemForm.solution_proposee"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" @click="if (saveProblem()) hideModal('problemModal')">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MODALE : recommandation (IV.2) --}}
    {{-- ============================================================ --}}
    <div class="modal fade" id="recommendationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" x-text="recommendationEditIndex === null ? 'Ajouter une recommandation' : 'Modifier la recommandation'"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Destinataire</label>
                        <textarea class="form-control" rows="2" x-model="recommendationForm.destinataire"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contenu</label>
                        <textarea class="form-control" rows="3" x-model="recommendationForm.contenu"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" @click="if (saveRecommendation()) hideModal('recommendationModal')">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function gouvernanceForm(initialSessions, initialAudits, initialProblems, initialRecommendations) {
        return {
            // Listes affichées dans les tableaux / cartes
            sessions: initialSessions.length ? initialSessions : [],
            audits: initialAudits.length ? initialAudits : [],
            problems: initialProblems.length ? initialProblems : [],
            recommendations: initialRecommendations.length ? initialRecommendations : [],

            // Buffers des formulaires pop-up + index en cours d'édition (null = ajout)
            sessionForm: { date_session: '', nb_recommandations_etablies: 0, nb_recommandations_realisees: 0 },
            sessionEditIndex: null,

            auditForm: { exercice_comptable: '', comptes_certifies_sans_reserves: '1', nb_recommandations_etablies: 0, nb_recommandations_realisees: 0 },
            auditEditIndex: null,

            problemForm: { probleme_rencontre: '', solution_proposee: '' },
            problemEditIndex: null,

            recommendationForm: { destinataire: '', contenu: '' },
            recommendationEditIndex: null,

            // Helpers d'affichage des modales Bootstrap
            showModal(id) {
                const el = document.getElementById(id);
                bootstrap.Modal.getOrCreateInstance(el).show();
            },
            hideModal(id) {
                const el = document.getElementById(id);
                bootstrap.Modal.getOrCreateInstance(el).hide();
            },

            // --- Sessions (tableau n°8) ---
            openSessionModal(index = null) {
                this.sessionEditIndex = index;
                this.sessionForm = index === null
                    ? { date_session: '', nb_recommandations_etablies: 0, nb_recommandations_realisees: 0 }
                    : { ...this.sessions[index] };
            },
            saveSession() {
                if (!this.sessionForm.date_session) {
                    alert('La date de la session est obligatoire.');
                    return false;
                }
                if (this.sessionEditIndex === null) {
                    this.sessions.push({ ...this.sessionForm });
                } else {
                    this.sessions[this.sessionEditIndex] = { ...this.sessionForm };
                }
                return true;
            },

            // --- Audits (tableau n°9) ---
            openAuditModal(index = null) {
                this.auditEditIndex = index;
                this.auditForm = index === null
                    ? { exercice_comptable: '', comptes_certifies_sans_reserves: '1', nb_recommandations_etablies: 0, nb_recommandations_realisees: 0 }
                    : { ...this.audits[index] };
            },
            saveAudit() {
                if (!this.auditForm.exercice_comptable) {
                    alert("L'exercice comptable est obligatoire.");
                    return false;
                }
                if (this.auditEditIndex === null) {
                    this.audits.push({ ...this.auditForm });
                } else {
                    this.audits[this.auditEditIndex] = { ...this.auditForm };
                }
                return true;
            },

            // --- Problèmes / solutions (IV.1) ---
            openProblemModal(index = null) {
                this.problemEditIndex = index;
                this.problemForm = index === null
                    ? { probleme_rencontre: '', solution_proposee: '' }
                    : { ...this.problems[index] };
            },
            saveProblem() {
                if (!this.problemForm.probleme_rencontre) {
                    alert('Le problème rencontré est obligatoire.');
                    return false;
                }
                if (this.problemEditIndex === null) {
                    this.problems.push({ ...this.problemForm });
                } else {
                    this.problems[this.problemEditIndex] = { ...this.problemForm };
                }
                return true;
            },

            // --- Recommandations (IV.2) ---
            openRecommendationModal(index = null) {
                this.recommendationEditIndex = index;
                this.recommendationForm = index === null
                    ? { destinataire: '', contenu: '' }
                    : { ...this.recommendations[index] };
            },
            saveRecommendation() {
                if (!this.recommendationForm.destinataire || !this.recommendationForm.contenu) {
                    alert('Le destinataire et le contenu sont obligatoires.');
                    return false;
                }
                if (this.recommendationEditIndex === null) {
                    this.recommendations.push({ ...this.recommendationForm });
                } else {
                    this.recommendations[this.recommendationEditIndex] = { ...this.recommendationForm };
                }
                return true;
            },
        };
    }
</script>
