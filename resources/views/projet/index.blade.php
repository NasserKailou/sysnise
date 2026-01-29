@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Liste des Projets</strong>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter un projet">
                        <a href="{{ route('projets.create') }}" style="color:#fff;text-decoration:none">
                            <i class="fa fa-plus"></i> Nouveau
                        </a>
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="dataTable table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left">Intitulé</th>
                                    <th class="text-left">Statut</th>
                                    <th class="text-left">Priorité</th>
                                    <th class="text-left">Tutelle</th>
                                    <th class="text-left">Période</th>
                                    <th class="text-left">Coût</th>
                                    <th class="text-left">Zones</th>
                                    <th class="text-center table-icons">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projets as $projet)
                                <tr>
                                    <td class="text-left">{{ $projet->intitule }}</td>
                                    <td class="text-left">{{ $projet->statutProjet?->intitule ?? '—'  }}</td>
                                    <td class="text-left">{{ $projet->priorite?->intitule ?? '—'  }}</td>
                                    <td class="text-left">{{ $projet->institutionTutelle?->intitule ?? '—'  }}</td>
                                    <td class="text-left">
                                        @if($projet->date_debut_prevue && $projet->date_fin_prevue)
                                            {{ \Carbon\Carbon::parse($projet->date_debut_prevue)->format('d/m/Y') }}- {{ \Carbon\Carbon::parse($projet->date_fin_prevue)->format('d/m/Y')}}
                                        @endif
                                    </td>
                                    <td class="text-left">{{ $projet->cout ?? '—' }}</td>
                                    <td class="text-left">{{ $projet->zoneInterventions->pluck('intitule')->implode(', ') }}</td>
                                    <td class="text-center table-icons">
                                        <a href="{{ route('projets.show', $projet->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Voir le détail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('projets.edit', $projet->id) }}" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton pour voir les associations -->
                                        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#viewProjetAssociationsModal{{ $projet->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Voir les associations">
                                            <i class="fa fa-list-alt"></i>
                                        </button>
                                        
                                        <!-- Bouton d'association -->
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#projetAssociationModal{{ $projet->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Associer à un utilisateur">
                                            <i class="fa fa-link"></i>
                                        </button>
                                        
                                        <form action="{{ route('projets.destroy', $projet->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer" onclick="return confirm('Supprimer ce projet ?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@foreach ($projets as $projet)
    <!-- Modal pour afficher les associations existantes du projet -->
    <div class="modal fade" id="viewProjetAssociationsModal{{ $projet->id }}" tabindex="-1" aria-labelledby="viewProjetAssociationsModalLabel{{ $projet->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewProjetAssociationsModalLabel{{ $projet->id }}">Associations de "{{ $projet->intitule }}"</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $associations = $projet->projetUsers; // Assurez-vous que la relation est définie dans le modèle Projet
                    @endphp
                    
                    @if($associations && $associations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Utilisateur</th>
                                        <th>Date d'association</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($associations as $association)
                                    <tr>
                                        <td>
                                            @if(is_object($association->user) && isset($association->user->email))
                                                {{ $association->user->email }}
                                            @elseif(is_numeric($association->user_id))
                                                @php
                                                    $user = $users->where('id', $association->user_id)->first();
                                                @endphp
                                                @if($user)
                                                    {{ $user->email }}
                                                @else
                                                    <span class="text-muted">Utilisateur ID: {{ $association->user_id }}</span>
                                                @endif
                                            @else
                                                <span class="text-muted">Non disponible</span>
                                            @endif
                                        </td>
                                        <td>{{ $association->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('projets.dissocier', ['association' => $association->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette association ?')">
                                                    <i class="fa fa-unlink"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <p class="text-muted">
                                <strong>{{ $associations->count() }}</strong> association(s) trouvée(s)
                            </p>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Aucune association pour ce projet.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal d'association pour chaque projet -->
    <div class="modal fade" id="projetAssociationModal{{ $projet->id }}" tabindex="-1" aria-labelledby="projetAssociationModalLabel{{ $projet->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projetAssociationModalLabel{{ $projet->id }}">Associer "{{ $projet->intitule }}" à un utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('projets.associer') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="projet_id" value="{{ $projet->id }}">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Utilisateur</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="">Sélectionner un utilisateur</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        @php
                            $associations = $projet->projetUsers;
                        @endphp
                        @if($associations && $associations->count() > 0)
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle"></i> 
                                Ce projet a déjà {{ $associations->count() }} association(s). 
                                Ajouter une nouvelle association ne supprimera pas les existantes.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Associer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach