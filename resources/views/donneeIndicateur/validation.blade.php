@extends('layouts.app')

@section('content')
<div class="container-fluid p-3" style="background:#fff">
    <div class="row mb-3">
        <div class="col-md-12">
            <h4 class="mb-3">
                <i class="fas fa-check-circle"></i> Validation des Données Indicateurs
            </h4>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-info-circle"></i> Actions Globales
                </div>
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success" onclick="validerSelection()">
                            <i class="fas fa-check"></i> Valider la sélection
                        </button>
                        <button type="button" class="btn btn-danger" onclick="rejeterSelection()">
                            <i class="fas fa-times"></i> Rejeter la sélection
                        </button>
                        <button type="button" class="btn btn-info" onclick="validerTout()">
                            <i class="fas fa-check-double"></i> Valider tout
                        </button>
                    </div>
                    <span class="ml-3 text-muted">
                        <i class="fas fa-info-circle"></i> 
                        <span id="count-selected">0</span> donnée(s) sélectionnée(s)
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-table"></i> Liste des Données en Attente de Validation ({{ $donnees->total() }})
                </div>
                <div class="card-body">
                    @if($donnees->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm" id="table-donnees">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">
                                            <input type="checkbox" id="select-all">
                                        </th>
                                        <th>ID</th>
                                        <th>Indicateur</th>
                                        <th>Zone</th>
                                        <th>Période</th>
                                        <th>Valeur</th>
                                        <th>Nature</th>
                                        <th>Source</th>
                                        <th>Unité</th>
                                        <th>Désagrégations</th>
                                        <th>Créé le</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($donnees as $donnee)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" class="donnee-checkbox" value="{{ $donnee->id }}">
                                            </td>
                                            <td>{{ $donnee->id }}</td>
                                            <td>{{ $donnee->indicateur->intitule ?? 'N/A' }}</td>
                                            <td>{{ $donnee->zone->intitule ?? 'N/A' }}</td>
                                            <td>{{ $donnee->periode->intitule ?? 'N/A' }}</td>
                                            <td><strong>{{ $donnee->valeur }}</strong></td>
                                            <td>{{ $donnee->natureDonnee->intitule ?? 'N/A' }}</td>
                                            <td>{{ $donnee->sourceIndicateur->intitule ?? 'N/A' }}</td>
                                            <td>{{ $donnee->uniteIndicateur->intitule ?? 'N/A' }}</td>
                                            <td>
                                                @if($donnee->desagregations->count() > 0)
                                                    <small>
                                                        {{ $donnee->desagregations->pluck('intitule')->implode(', ') }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $donnee->created_at->format('d/m/Y H:i') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <form method="POST" style="display: inline-block;" action="{{ route('donneeIndicateur.valider', $donnee->id) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Valider">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        title="Rejeter" 
                                                        onclick="openRejectModal({{ $donnee->id }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $donnees->links() }}
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i> Aucune donnée en attente de validation.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Rejet Individuel -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="fas fa-times-circle"></i> Rejeter la Donnée
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="commentaire_rejet">
                            <i class="fas fa-comment"></i> Commentaire de Rejet
                        </label>
                        <textarea 
                            class="form-control" 
                            id="commentaire_rejet" 
                            name="commentaire_rejet" 
                            rows="4" 
                            placeholder="Veuillez préciser la raison du rejet... (optionnel)"
                        ></textarea>
                        <small class="form-text text-muted">
                            Maximum 1000 caractères
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-check"></i> Confirmer le Rejet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Rejet Global -->
<div class="modal fade" id="rejectGlobalModal" tabindex="-1" role="dialog" aria-labelledby="rejectGlobalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectGlobalModalLabel">
                    <i class="fas fa-times-circle"></i> Rejeter la Sélection
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectGlobalForm" method="POST" action="{{ route('donneeIndicateur.rejeter.global') }}">
                @csrf
                <div class="modal-body">
                    <p>
                        <strong>Nombre de données à rejeter : <span id="reject-count">0</span></strong>
                    </p>
                    <div class="form-group">
                        <label for="commentaire_rejet_global">
                            <i class="fas fa-comment"></i> Commentaire de Rejet (pour toutes les données)
                        </label>
                        <textarea 
                            class="form-control" 
                            id="commentaire_rejet_global" 
                            name="commentaire_rejet" 
                            rows="4" 
                            placeholder="Veuillez préciser la raison du rejet... (optionnel)"
                        ></textarea>
                        <small class="form-text text-muted">
                            Maximum 1000 caractères. Ce commentaire sera appliqué à toutes les données sélectionnées.
                        </small>
                    </div>
                    <input type="hidden" name="donnees_ids" id="donnees_ids_global">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-check"></i> Confirmer le Rejet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Sélectionner/Désélectionner tout
    $('#select-all').on('change', function() {
        $('.donnee-checkbox').prop('checked', $(this).prop('checked'));
        updateSelectedCount();
    });

    // Mettre à jour le compteur quand une checkbox change
    $('.donnee-checkbox').on('change', function() {
        updateSelectedCount();
        
        // Mettre à jour le "select all" si nécessaire
        if ($('.donnee-checkbox:checked').length === $('.donnee-checkbox').length) {
            $('#select-all').prop('checked', true);
        } else {
            $('#select-all').prop('checked', false);
        }
    });

    // Mettre à jour le compteur initial
    updateSelectedCount();
});

function updateSelectedCount() {
    const count = $('.donnee-checkbox:checked').length;
    $('#count-selected').text(count);
}

function getSelectedIds() {
    const selectedIds = [];
    $('.donnee-checkbox:checked').each(function() {
        selectedIds.push($(this).val());
    });
    return selectedIds;
}

function openRejectModal(id) {
    const form = document.getElementById('rejectForm');
    form.action = "{{ url('/donnee_indicateurs') }}/" + id + "/rejeter";
    $('#commentaire_rejet').val('');
    $('#rejectModal').modal('show');
}

function validerSelection() {
    const ids = getSelectedIds();
    
    if (ids.length === 0) {
        alert('Veuillez sélectionner au moins une donnée.');
        return;
    }
    
    if (confirm(`Voulez-vous vraiment valider ${ids.length} donnée(s) ?`)) {
        submitAction('{{ route("donneeIndicateur.valider.global") }}', ids);
    }
}

function rejeterSelection() {
    const ids = getSelectedIds();
    
    if (ids.length === 0) {
        alert('Veuillez sélectionner au moins une donnée.');
        return;
    }
    
    // Ouvrir le modal avec le nombre de données
    $('#reject-count').text(ids.length);
    $('#commentaire_rejet_global').val('');
    
    // Créer un champ hidden pour chaque ID
    let idsInput = '';
    ids.forEach(id => {
        idsInput += `<input type="hidden" name="donnees_ids[]" value="${id}">`;
    });
    $('#donnees_ids_global').replaceWith(idsInput);
    
    $('#rejectGlobalModal').modal('show');
}

function validerTout() {
    const total = {{ $donnees->total() }};
    
    if (total === 0) {
        alert('Aucune donnée à valider.');
        return;
    }
    
    if (confirm(`Voulez-vous vraiment valider TOUTES les ${total} donnée(s) en attente ?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("donneeIndicateur.valider.tout") }}';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function submitAction(url, ids) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);
    
    ids.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'donnees_ids[]';
        input.value = id;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
}
</script>

<style>
.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
@endsection
