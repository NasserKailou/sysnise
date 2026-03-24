@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
      <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="form-section">
          <div class="section-title d-flex justify-content-between">
            <span>Liste des cadres de développement</span>
            <button class="mr-3 btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter un cadre">
              <a href="{{ url('/cadre_developpements/create/') }}" style="color:#fff;text-decoration:none">
                <i class="fa fa-plus"></i> Nouveau
              </a>
            </button>
          </div>

          <div class="table-responsive">
            <table class="dataTable table table-striped table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>Intitulé</th>
                  <th>Responsable</th>
                  <th>Période</th>
                  <th class="text-center table-icons">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($cadreDeveloppements as $cadre)
                <tr>
                  <td>{{ $cadre->intitule }}</td>
                  <td>{{ $cadre->structure_responsable }}</td>
                  <td>{{ $cadre->annee_debut }}- {{ $cadre->annee_fin }}</td>
                  <td class="text-center table-icons">
                    <a href="{{ route('cadre_developpements.show', $cadre->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Voir les détails">
                      <i class="fa fa-eye"></i>
                    </a>
                    <a href="{{ route('cadre_developpements.cadres_logiques.index', $cadre->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Afficher les cadres logiques">
                      <i class="fa fa-list"></i>
                    </a>
                    <a href="{{ route('cadre_developpements.edit', $cadre->id) }}" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier">
                      <i class="fa fa-pen"></i>
                    </a>
                    <a href="{{ route('export_cadre_data_template', $cadre->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Télécharger modèle de chargement">
                      <i class="fa fa-download"></i>
                    </a>
                    
                    <!-- Bouton pour voir les associations -->
                    <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#viewAssociationsModal{{ $cadre->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Voir les associations">
                      <i class="fa fa-list-alt"></i>
                    </button>
                    
                    <!-- Bouton d'association -->
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#associationModal{{ $cadre->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Associer à une user">
                      <i class="fa fa-link"></i>
                    </button>
                    
                    <form action="{{ route('cadre_developpements.destroy', $cadre->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer" onclick="return confirm('Supprimer cet article ?')">
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
@endsection

@foreach ($cadreDeveloppements as $cadre)

  <!-- Modal pour afficher les associations existantes -->
                <div class="modal fade" id="viewAssociationsModal{{ $cadre->id }}" tabindex="-1" aria-labelledby="viewAssociationsModalLabel{{ $cadre->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="viewAssociationsModalLabel{{ $cadre->id }}">Associations de "{{ $cadre->intitule }}"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        @php
                            $associations = $cadre->cadreDeveloppementusers;
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
                                    @if(is_object($association->userr) && isset($association->userr->email))
                                      {{ $association->userr->email }}
                                    @elseif(is_numeric($association->userr))
                                      <!-- Si c'est juste un ID, trouvez l'userr correspondante -->
                                      @php
                                          $inst = $users->where('id', $association->userr)->first();
                                      @endphp
                                      @if($inst)
                                        {{ $inst->email }}
                                      @else
                                        <span class="text-muted">Utilisateur ID: {{ $association->userr }}</span>
                                      @endif
                                    @else
                                      <span class="text-muted">Non disponible</span>
                                    @endif
                                  </td>
                                  <td>{{ $association->created_at->format('d/m/Y H:i') }}</td>
                                  <td>
                                    <form action="{{ route('cadre_developpements.dissocier', ['association' => $association->id]) }}" method="POST" class="d-inline">
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
                            <i class="fa fa-info-circle"></i> Aucune association pour ce cadre de développement.
                          </div>
                        @endif
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Modal d'association pour chaque cadre -->
                <div class="modal fade" id="associationModal{{ $cadre->id }}" tabindex="-1" aria-labelledby="associationModalLabel{{ $cadre->id }}" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="associationModalLabel{{ $cadre->id }}">Associer "{{ $cadre->intitule }}" à un utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="{{ route('cadre_developpements.associer') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                          <input type="hidden" name="cadre_developpement_id" value="{{ $cadre->id }}">
                          <div class="mb-3">
                            <label for="user_id" class="form-label">user</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                              <option value="">Sélectionner un utilisateur</option>
                              @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->email }}</option>
                              @endforeach
                            </select>
                          </div>
                          @php
                              $associations = $cadre->cadreDeveloppementusers;
                          @endphp
                          @if($associations && $associations->count() > 0)
                            <div class="alert alert-warning">
                              <i class="fa fa-exclamation-triangle"></i> 
                              Ce cadre a déjà {{ $associations->count() }} association(s). 
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