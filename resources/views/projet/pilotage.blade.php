@extends('layouts.app')  {{-- ou votre layout --}}

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h1 class="h3">Pilotage & Audits - Projet : {{ $projet->sigle }} ({{ $projet->intitule }})</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('projets.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    {{-- Affichage des messages flash --}}
    @include('partials.flash')

    {{-- Formulaire général --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Informations générales</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('projets.pilotage.updateGeneral', $projet) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="dispose_organe_pilotage" id="dispose_organe_pilotage" value="1" {{ $projet->dispose_organe_pilotage ? 'checked' : '' }}>
                            <label class="form-check-label" for="dispose_organe_pilotage">Le projet dispose-t-il d’un organe d’orientation/pilotage ?</label>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="a_audit_regulier" id="a_audit_regulier" value="1" {{ $projet->a_audit_regulier ? 'checked' : '' }}>
                            <label class="form-check-label" for="a_audit_regulier">Les comptes du projet ont-ils fait l’objet régulièrement d’audit ?</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="rapport_rempli_par" class="form-label">Rempli par</label>
                            <input type="text" class="form-control" id="rapport_rempli_par" name="rapport_rempli_par" value="{{ old('rapport_rempli_par', $projet->rapport_rempli_par) }}">
                        </div>
                        <div class="mb-3">
                            <label for="rapport_date_remplissage" class="form-label">Date de remplissage</label>
                            <input type="date" class="form-control" id="rapport_date_remplissage" name="rapport_date_remplissage" value="{{ old('rapport_date_remplissage', $projet->rapport_date_remplissage ? $projet->rapport_date_remplissage->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="problemes_rencontres" class="form-label">Problèmes rencontrés dans la mise en œuvre</label>
                            <textarea class="form-control" id="problemes_rencontres" name="problemes_rencontres" rows="3">{{ old('problemes_rencontres', $projet->problemes_rencontres) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="solutions_proposees" class="form-label">Solutions proposées</label>
                            <textarea class="form-control" id="solutions_proposees" name="solutions_proposees" rows="3">{{ old('solutions_proposees', $projet->solutions_proposees) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="recommandations" class="form-label">Recommandations</label>
                            <textarea class="form-control" id="recommandations" name="recommandations" rows="3">{{ old('recommandations', $projet->recommandations) }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications générales</button>
            </form>
        </div>
    </div>

    {{-- Section Organe de pilotage (affichée seulement si coché) --}}
    @if($projet->dispose_organe_pilotage)
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Organe de pilotage - Sessions et recommandations</h5>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalAjoutPilotageAnnee">
                <i class="fas fa-plus"></i> Ajouter une année
            </button>
        </div>
        <div class="card-body">
            @if($projet->pilotageAnnees->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Année</th>
                            <th>Sessions prévues</th>
                            <th>Sessions tenues</th>
                            <th>Dates des sessions</th>
                            <th>Recommandations formulées</th>
                            <th>Recommandations mises en œuvre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projet->pilotageAnnees as $annee)
                        <tr>
                            <td>{{ $annee->annee }}</td>
                            <td>{{ $annee->nb_sessions_prevues }}</td>
                            <td>{{ $annee->nb_sessions_tenues }}</td>
                            <td>
                                @foreach($annee->sessions as $session)
                                    {{ $session->date_session->format('d/m/Y') }}<br>
                                @endforeach
                            </td>
                            <td>{{ $annee->nb_recommandations_formulees }}</td>
                            <td>{{ $annee->nb_recommandations_mises_oeuvre }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit-pilotage" data-id="{{ $annee->id }}" data-bs-toggle="modal" data-bs-target="#modalEditPilotageAnnee">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('projets.pilotage-annees.destroy', [$projet, $annee]) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette année ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted">Aucune année de pilotage enregistrée.</p>
            @endif
        </div>
    </div>
    @endif

    {{-- Section Audits (affichée seulement si coché) --}}
    @if($projet->a_audit_regulier)
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Audits - Exercices comptables</h5>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalAjoutAuditExercice">
                <i class="fas fa-plus"></i> Ajouter un exercice
            </button>
        </div>
        <div class="card-body">
            @if($projet->auditsExercices->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Exercice</th>
                            <th>Comptes certifiés sans réserves</th>
                            <th>Recommandations formulées</th>
                            <th>Recommandations mises en œuvre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projet->auditsExercices as $exercice)
                        <tr>
                            <td>{{ $exercice->exercice }}</td>
                            <td>
                                @if($exercice->comptes_certifies === null)
                                    Non renseigné
                                @elseif($exercice->comptes_certifies)
                                    Oui
                                @else
                                    Non
                                @endif
                            </td>
                            <td>{{ $exercice->nb_recommandations_formulees }}</td>
                            <td>{{ $exercice->nb_recommandations_mises_oeuvre }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit-audit" data-id="{{ $exercice->id }}" data-bs-toggle="modal" data-bs-target="#modalEditAuditExercice">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('projets.audits-exercices.destroy', [$projet, $exercice]) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet exercice ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted">Aucun exercice d'audit enregistré.</p>
            @endif
        </div>
    </div>
    @endif

    {{-- Section Rapports --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Rapports périodiques</h5>
            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalAjoutRapport">
                <i class="fas fa-plus"></i> Ajouter un rapport
            </button>
        </div>
        <div class="card-body">
            @if($projet->rapports->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Date du rapport</th>
                            <th>Description</th>
                            <th>Fichier</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projet->rapports as $rapport)
                        <tr>
                            <td>{{ ucfirst($rapport->type) }}</td>
                            <td>{{ $rapport->date_rapport ? $rapport->date_rapport->format('d/m/Y') : '' }}</td>
                            <td>{{ $rapport->description }}</td>
                            <td><a href="{{ $rapport->url }}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-download"></i> Télécharger</a></td>
                            <td>
                                <form action="{{ route('projets.rapports.destroy', [$projet, $rapport]) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce rapport ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted">Aucun rapport enregistré.</p>
            @endif
        </div>
    </div>
</div>

{{-- Modales --}}

{{-- Modal Ajout Année Pilotage --}}
<div class="modal fade" id="modalAjoutPilotageAnnee" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('projets.pilotage-annees.store', $projet) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une année de pilotage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="annee" class="form-label">Année</label>
                                <input type="number" class="form-control @error('annee') is-invalid @enderror" id="annee" name="annee" value="{{ old('annee') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="nb_sessions_prevues" class="form-label">Nombre de sessions prévues</label>
                                <input type="number" class="form-control" id="nb_sessions_prevues" name="nb_sessions_prevues" value="{{ old('nb_sessions_prevues', 0) }}">
                            </div>
                            <div class="mb-3">
                                <label for="nb_sessions_tenues" class="form-label">Nombre de sessions tenues</label>
                                <input type="number" class="form-control" id="nb_sessions_tenues" name="nb_sessions_tenues" value="{{ old('nb_sessions_tenues', 0) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nb_recommandations_formulees" class="form-label">Recommandations formulées</label>
                                <input type="number" class="form-control" id="nb_recommandations_formulees" name="nb_recommandations_formulees" value="{{ old('nb_recommandations_formulees', 0) }}">
                            </div>
                            <div class="mb-3">
                                <label for="nb_recommandations_mises_oeuvre" class="form-label">Recommandations mises en œuvre</label>
                                <input type="number" class="form-control" id="nb_recommandations_mises_oeuvre" name="nb_recommandations_mises_oeuvre" value="{{ old('nb_recommandations_mises_oeuvre', 0) }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dates des sessions</label>
                        <div id="sessions-container">
                            <div class="input-group mb-2">
                                <input type="date" class="form-control" name="sessions[]">
                                <button class="btn btn-outline-secondary add-session" type="button"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <small class="text-muted">Ajoutez autant de dates que nécessaire.</small>
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

{{-- Modal Édition Année Pilotage --}}
<div class="modal fade" id="modalEditPilotageAnnee" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="POST" id="formEditPilotageAnnee">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Modifier l'année de pilotage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- Les champs seront remplis par JS --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_annee" class="form-label">Année</label>
                                <input type="number" class="form-control" id="edit_annee" name="annee" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_nb_sessions_prevues" class="form-label">Nombre de sessions prévues</label>
                                <input type="number" class="form-control" id="edit_nb_sessions_prevues" name="nb_sessions_prevues">
                            </div>
                            <div class="mb-3">
                                <label for="edit_nb_sessions_tenues" class="form-label">Nombre de sessions tenues</label>
                                <input type="number" class="form-control" id="edit_nb_sessions_tenues" name="nb_sessions_tenues">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_nb_recommandations_formulees" class="form-label">Recommandations formulées</label>
                                <input type="number" class="form-control" id="edit_nb_recommandations_formulees" name="nb_recommandations_formulees">
                            </div>
                            <div class="mb-3">
                                <label for="edit_nb_recommandations_mises_oeuvre" class="form-label">Recommandations mises en œuvre</label>
                                <input type="number" class="form-control" id="edit_nb_recommandations_mises_oeuvre" name="nb_recommandations_mises_oeuvre">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dates des sessions</label>
                        <div id="edit-sessions-container">
                            {{-- Ici on ajoutera dynamiquement les champs --}}
                        </div>
                        <button class="btn btn-sm btn-outline-secondary add-edit-session" type="button"><i class="fas fa-plus"></i> Ajouter une date</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Ajout Audit Exercice --}}
<div class="modal fade" id="modalAjoutAuditExercice" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projets.audits-exercices.store', $projet) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un exercice d'audit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exercice" class="form-label">Exercice</label>
                        <input type="number" class="form-control" id="exercice" name="exercice" required>
                    </div>
                    <div class="mb-3">
                        <label for="comptes_certifies" class="form-label">Comptes certifiés sans réserves</label>
                        <select class="form-control" id="comptes_certifies" name="comptes_certifies">
                            <option value="">-- Sélectionnez --</option>
                            <option value="1">Oui</option>
                            <option value="0">Non</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nb_recommandations_formulees" class="form-label">Recommandations formulées</label>
                        <input type="number" class="form-control" id="nb_recommandations_formulees" name="nb_recommandations_formulees" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="nb_recommandations_mises_oeuvre" class="form-label">Recommandations mises en œuvre</label>
                        <input type="number" class="form-control" id="nb_recommandations_mises_oeuvre" name="nb_recommandations_mises_oeuvre" value="0">
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

{{-- Modal Édition Audit Exercice --}}
<div class="modal fade" id="modalEditAuditExercice" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST" id="formEditAuditExercice">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Modifier l'exercice d'audit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_exercice" class="form-label">Exercice</label>
                        <input type="number" class="form-control" id="edit_exercice" name="exercice" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_comptes_certifies" class="form-label">Comptes certifiés sans réserves</label>
                        <select class="form-control" id="edit_comptes_certifies" name="comptes_certifies">
                            <option value="">-- Sélectionnez --</option>
                            <option value="1">Oui</option>
                            <option value="0">Non</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nb_recommandations_formulees" class="form-label">Recommandations formulées</label>
                        <input type="number" class="form-control" id="edit_nb_recommandations_formulees" name="nb_recommandations_formulees">
                    </div>
                    <div class="mb-3">
                        <label for="edit_nb_recommandations_mises_oeuvre" class="form-label">Recommandations mises en œuvre</label>
                        <input type="number" class="form-control" id="edit_nb_recommandations_mises_oeuvre" name="nb_recommandations_mises_oeuvre">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Ajout Rapport --}}
<div class="modal fade" id="modalAjoutRapport" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projets.rapports.store', $projet) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un rapport</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type de rapport</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">-- Choisir --</option>
                            <option value="bilan">Bilan</option>
                            <option value="audit">Audit</option>
                            <option value="mission">Mission de suivi</option>
                            <option value="aide_memoire">Aide-mémoire</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_rapport" class="form-label">Date du rapport</label>
                        <input type="date" class="form-control" id="date_rapport" name="date_rapport">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fichier" class="form-label">Fichier (PDF, DOC, etc.)</label>
                        <input type="file" class="form-control" id="fichier" name="fichier" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Uploader</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Gestion de l'ajout dynamique de champs de date dans le modal d'ajout
    $(document).on('click', '.add-session', function() {
        var container = $('#sessions-container');
        var newField = '<div class="input-group mb-2"><input type="date" class="form-control" name="sessions[]"><button class="btn btn-outline-danger remove-session" type="button"><i class="fas fa-times"></i></button></div>';
        container.append(newField);
    });

    $(document).on('click', '.remove-session', function() {
        $(this).closest('.input-group').remove();
    });

    // Pour le modal d'édition, on utilisera un conteneur spécifique
    $(document).on('click', '.add-edit-session', function() {
        var container = $('#edit-sessions-container');
        var newField = '<div class="input-group mb-2"><input type="date" class="form-control" name="sessions[]"><button class="btn btn-outline-danger remove-edit-session" type="button"><i class="fas fa-times"></i></button></div>';
        container.append(newField);
    });

    $(document).on('click', '.remove-edit-session', function() {
        $(this).closest('.input-group').remove();
    });

    // Chargement des données pour l'édition d'une année de pilotage
    $('.btn-edit-pilotage').click(function() {
        var id = $(this).data('id');
      var url = "{{ route('projets.pilotage-annees.edit', ['projet' => $projet->id, 'annee' => '999999']) }}".replace('999999', id);
$('#formEditPilotageAnnee').attr('action', "{{ route('projets.pilotage-annees.update', ['projet' => $projet->id, 'annee' => '999999']) }}".replace('999999', id));            $('#edit_annee').val(data.annee);
            $('#edit_nb_sessions_prevues').val(data.nb_sessions_prevues);
            $('#edit_nb_sessions_tenues').val(data.nb_sessions_tenues);
            $('#edit_nb_recommandations_formulees').val(data.nb_recommandations_formulees);
            $('#edit_nb_recommandations_mises_oeuvre').val(data.nb_recommandations_mises_oeuvre);
            // Vider et remplir les sessions
            var container = $('#edit-sessions-container');
            container.empty();
            if (data.sessions && data.sessions.length) {
                $.each(data.sessions, function(index, session) {
                    var date = session.date_session ? session.date_session.substring(0,10) : '';
                    var field = '<div class="input-group mb-2"><input type="date" class="form-control" name="sessions[]" value="' + date + '"><button class="btn btn-outline-danger remove-edit-session" type="button"><i class="fas fa-times"></i></button></div>';
                    container.append(field);
                });
            }
        });
    });

    // Chargement des données pour l'édition d'un exercice d'audit
    $('.btn-edit-audit').click(function() {
        var id = $(this).data('id');
        var url = "{{ route('projets.audits-exercices.edit', ['projet' => $projet->id, 'exercice' => '999999']) }}".replace('999999', id);
$('#formEditAuditExercice').attr('action', "{{ route('projets.audits-exercices.update', ['projet' => $projet->id, 'exercice' => '999999']) }}".replace('999999', id));            $('#edit_exercice').val(data.exercice);
            $('#edit_comptes_certifies').val(data.comptes_certifies !== null ? (data.comptes_certifies ? '1' : '0') : '');
            $('#edit_nb_recommandations_formulees').val(data.nb_recommandations_formulees);
            $('#edit_nb_recommandations_mises_oeuvre').val(data.nb_recommandations_mises_oeuvre);
        });
    });

    // Ouvrir automatiquement une modale si l'URL contient un hash correspondant
    if (window.location.hash) {
        var hash = window.location.hash;
        $(hash).modal('show');
    }
});
</script>
@endpush