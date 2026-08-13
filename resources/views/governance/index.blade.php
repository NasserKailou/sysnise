@extends('layouts.app')

{{--
    Fiche Gouvernance du projet : pilotage, audits, problèmes/solutions,
    recommandations.

    Dépendances : Bootstrap 5 (CSS + JS bundle) et Alpine.js, chargés
    dans le layout parent. Les ajouts (session, recommandation, exercice
    d'audit, problème, solution, recommandation finale) se font via des
    formulaires en pop-up (modales Bootstrap), pilotés par Alpine.js
    pour renseigner dynamiquement l'action du formulaire et les
    éventuels champs cachés (id de la session/exercice/problème cible).
--}}

@section('content')
<div class="container" x-data="{
        sessionModalAction: '{{ route('projets.governance.sessions.store', $projet) }}',
        auditExerciceModalAction: '{{ route('projets.governance.audit.exercices.store', $projet) }}',
    }">

    {{--<h1 class="h3 mb-4">Gouvernance du projet : {{ $projet->intitule ?? $projet->intitule ?? $projet->id }}</h1>--}}

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ============================================================
         I. PILOTAGE ET AUDITS
         ============================================================ --}}
    <h2 class="h4 mt-4">I. Pilotage et audits</h2>

    {{-- 3.1 Fonctionnement de l'organe d'orientation/pilotage --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>3.1 Fonctionnement de l'organe d'orientation/pilotage</span>
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#sessionModal">
                + Ajouter une session
            </button>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('projets.governance.pilotage.update', $projet) }}" class="row g-3 mb-4">
                @csrf
                @method('PUT')
                <div class="col-md-4">
                    <label class="form-label">Organe de pilotage en place ?</label>
                    <select name="dispose_organe_pilotage" class="form-select" required>
                        <option value="1" @selected(optional($pilotage)->dispose_organe_pilotage === true)>Oui</option>
                        <option value="0" @selected(optional($pilotage)->dispose_organe_pilotage === false)>Non</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nombre de sessions prévues dans l'année</label>
                    <input type="number" min="0" name="nombre_sessions_prevues" class="form-control"
                           value="{{ optional($pilotage)->nombre_sessions_prevues }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nombre de sessions tenues dans l'année</label>
                    <input type="number" min="0" name="nombre_sessions_tenues" class="form-control"
                           value="{{ optional($pilotage)->nombre_sessions_tenues }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                </div>
            </form>

            @forelse (optional($pilotage)->sessions ?? [] as $session)
                <div class="border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Session du {{ $session->date_session->format('d/m/Y') }}</strong>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#sessionRecoModal{{ $session->id }}">
                                + Recommandation
                            </button>
                            <form method="POST" action="{{ route('projets.governance.sessions.destroy', [$projet, $session]) }}" class="d-inline"
                                  onsubmit="return confirm('Supprimer cette session ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush mt-2">
                        @forelse ($session->recommandations as $reco)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="{{ $reco->est_realisee ? 'text-decoration-line-through text-muted' : '' }}">
                                    {{ $reco->libelle }}
                                </span>
                                <span>
                                    <form method="POST" action="{{ route('projets.governance.sessions.recommandations.toggle', [$projet, $reco]) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $reco->est_realisee ? 'btn-success' : 'btn-outline-success' }}">
                                            {{ $reco->est_realisee ? 'Réalisée' : 'Marquer réalisée' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('projets.governance.sessions.recommandations.destroy', [$projet, $reco]) }}" class="d-inline"
                                          onsubmit="return confirm('Supprimer cette recommandation ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">×</button>
                                    </form>
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Aucune recommandation saisie pour cette session.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Modale : recommandation de CETTE session (action fixée côté serveur) --}}
                <div class="modal fade" id="sessionRecoModal{{ $session->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('projets.governance.sessions.recommandations.store', [$projet, $session]) }}">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter une recommandation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label">Libellé de la recommandation</label>
                                    <textarea name="libelle" class="form-control" rows="3" required></textarea>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="est_realisee" value="1" class="form-check-input" id="sessionRecoRealisee{{ $session->id }}">
                                        <label class="form-check-label" for="sessionRecoRealisee{{ $session->id }}">Déjà réalisée</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Aucune session enregistrée.</p>
            @endforelse
        </div>
    </div>

    {{-- 3.2 Audits --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>3.2 Audits des comptes du projet</span>
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#auditExerciceModal">
                + Ajouter un exercice comptable
            </button>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('projets.governance.audit.update', $projet) }}" class="row g-3 mb-4">
                @csrf
                @method('PUT')
                <div class="col-md-4">
                    <label class="form-label">Comptes régulièrement audités ?</label>
                    <select name="comptes_audites" class="form-select" required>
                        <option value="1" @selected(optional($audit)->comptes_audites === true)>Oui</option>
                        <option value="0" @selected(optional($audit)->comptes_audites === false)>Non</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Nombre d'audits réalisés (depuis le démarrage)</label>
                    <input type="number" min="0" name="nombre_audits_realises" class="form-control"
                           value="{{ optional($audit)->nombre_audits_realises }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Commentaire</label>
                    <input type="text" name="commentaire" class="form-control" placeholder="Ex : premier audit attendu en mai 2026…"
                           value="{{ optional($audit)->commentaire }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                </div>
            </form>

            @forelse (optional($audit)->exercices ?? [] as $exercice)
                <div class="border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>
                            Exercice {{ $exercice->exercice_comptable }} —
                            comptes certifiés sans réserve :
                            <span class="badge {{ $exercice->comptes_certifies_sans_reserves ? 'bg-success' : 'bg-danger' }}">
                                {{ $exercice->comptes_certifies_sans_reserves ? 'Oui' : 'Non' }}
                            </span>
                        </strong>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#auditRecoModal{{ $exercice->id }}">
                                + Recommandation
                            </button>
                            <form method="POST" action="{{ route('projets.governance.audit.exercices.destroy', [$projet, $exercice]) }}" class="d-inline"
                                  onsubmit="return confirm('Supprimer cet exercice ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush mt-2">
                        @forelse ($exercice->recommandations as $reco)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="{{ $reco->est_realisee ? 'text-decoration-line-through text-muted' : '' }}">
                                    {{ $reco->libelle }}
                                </span>
                                <span>
                                    <form method="POST" action="{{ route('projets.governance.audit.recommandations.toggle', [$projet, $reco]) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $reco->est_realisee ? 'btn-success' : 'btn-outline-success' }}">
                                            {{ $reco->est_realisee ? 'Réalisée' : 'Marquer réalisée' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('projets.governance.audit.recommandations.destroy', [$projet, $reco]) }}" class="d-inline"
                                          onsubmit="return confirm('Supprimer cette recommandation ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">×</button>
                                    </form>
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Aucune recommandation saisie pour cet exercice.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Modale : recommandation de CET exercice (action fixée côté serveur) --}}
                <div class="modal fade" id="auditRecoModal{{ $exercice->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('projets.governance.audit.recommandations.store', [$projet, $exercice]) }}">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter une recommandation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label">Libellé de la recommandation</label>
                                    <textarea name="libelle" class="form-control" rows="3" required></textarea>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="est_realisee" value="1" class="form-check-input" id="auditRecoRealisee{{ $exercice->id }}">
                                        <label class="form-check-label" for="auditRecoRealisee{{ $exercice->id }}">Déjà réalisée</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Aucun exercice comptable enregistré.</p>
            @endforelse
        </div>
    </div>

    {{-- ============================================================
         II. PROBLEMES RENCONTRES, SOLUTIONS PROPOSEES ET RECOMMANDATIONS
         ============================================================ --}}
    <h2 class="h4 mt-4">II. Problèmes rencontrés, solutions proposées et recommandations</h2>

    {{-- IV.1 Problèmes rencontrés et solutions proposées --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>IV.1 Problèmes rencontrés et solutions proposées</span>
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#problemeModal">
                + Ajouter un problème
            </button>
        </div>
        <div class="card-body">
            @forelse ($problemes as $probleme)
                <div class="border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ $probleme->libelle }}</strong>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#solutionModal{{ $probleme->id }}">
                                + Solution
                            </button>
                            <form method="POST" action="{{ route('projets.governance.problemes.destroy', [$projet, $probleme]) }}" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce problème ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush mt-2">
                        @forelse ($probleme->solutions as $solution)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $solution->libelle }}
                                <form method="POST" action="{{ route('projets.governance.solutions.destroy', [$projet, $solution]) }}" class="d-inline"
                                      onsubmit="return confirm('Supprimer cette solution ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">×</button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Aucune solution proposée pour ce problème.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Modale : solution pour CE problème (action fixée côté serveur) --}}
                <div class="modal fade" id="solutionModal{{ $probleme->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('projets.governance.problemes.solutions.store', [$projet, $probleme]) }}">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter une solution proposée</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label">Description de la solution</label>
                                    <textarea name="libelle" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Aucun problème enregistré.</p>
            @endforelse
        </div>
    </div>

    {{-- IV.2 Recommandations --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>IV.2 Recommandations</span>
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#recommandationModal">
                + Ajouter une recommandation
            </button>
        </div>
        <div class="card-body">
            @forelse ($recommandations as $destinataire => $items)
                <div class="mb-3">
                    <h6 class="text-uppercase text-muted">À l'attention de : {{ $destinataire }}</h6>
                    <ul class="list-group list-group-flush">
                        @foreach ($items as $reco)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $reco->libelle }}
                                <form method="POST" action="{{ route('projets.governance.recommandations.destroy', [$projet, $reco]) }}" class="d-inline"
                                      onsubmit="return confirm('Supprimer cette recommandation ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">×</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-muted">Aucune recommandation enregistrée.</p>
            @endforelse
        </div>
    </div>

    {{-- ============================================================
         MODALES (formulaires en pop-up)
         ============================================================ --}}

    {{-- Modale : nouvelle session de pilotage --}}
    <div class="modal fade" id="sessionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" :action="sessionModalAction">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter une session</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Date de la session</label>
                        <input type="date" name="date_session" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modale : nouvel exercice comptable (audit) --}}
    <div class="modal fade" id="auditExerciceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" :action="auditExerciceModalAction">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un exercice comptable</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Exercice comptable</label>
                            <input type="text" name="exercice_comptable" class="form-control" placeholder="Ex : 2024" required>
                        </div>
                        <div>
                            <label class="form-label">Comptes certifiés sans réserve ?</label>
                            <select name="comptes_certifies_sans_reserves" class="form-select" required>
                                <option value="1">Oui</option>
                                <option value="0">Non</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modale : nouveau problème --}}
    <div class="modal fade" id="problemeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('projets.governance.problemes.store', $projet) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un problème rencontré</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Description du problème</label>
                        <textarea name="libelle" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modale : nouvelle recommandation finale --}}
    <div class="modal fade" id="recommandationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('projets.governance.recommandations.store', $projet) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter une recommandation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Adressée à</label>
                            <input type="text" name="destinataire" class="form-control"
                                   placeholder="Ex : Structures partenaires de mise en œuvre, MAGEL…" required>
                        </div>
                        <div>
                            <label class="form-label">Libellé de la recommandation</label>
                            <textarea name="libelle" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

{{--
    Rappel : le layout parent (layouts.app) doit charger Bootstrap 5
    (CSS + bundle JS incluant Popper) et Alpine.js, par exemple via CDN :

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
--}}
