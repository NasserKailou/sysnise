@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Liste des Projets</strong>
                    <a href="{{ route('projets.create') }}" 
					   class="btn btn-primary btn-sm ms-auto"
					   data-bs-toggle="tooltip" 
					   data-bs-placement="top" 
					   title="Ajouter un projet">
						<i class="fa fa-plus"></i> Nouveau
					</a>
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
                                        <button class="btn btn-dark btn-sm open-modal viewAssociationsModal"
											data-id="{{ $projet->id }}"
											data-intitule="{{ $projet->intitule }}"
											data-bs-toggle="modal">
											<i class="fa fa-list-alt"></i>
										</button>
                                        
                                        <!-- Bouton d'association -->
                                        <button class="btn btn-secondary btn-sm open-association-modal associationModal"
											data-id="{{ $projet->id }}"
											data-intitule="{{ $projet->intitule }}"
											data-bs-toggle="modal">
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

<div id="popup"></div>
<script>
	$(document).ready(function () {
		
		$('.viewAssociationsModal').click(function(){
				projetId = $(this).data('id');
				$.get('/projets/'+projetId+'/viewAssociations',function(dat){
					$('#popup').html(dat);
					$("#viewAssociationsModal").modal('show');
				});
				
			});
			
		$('.associationModal').click(function(){
				projetId = $(this).data('id');
				$.get('/projets/'+projetId+'/association',function(dat){
					$('#popup').html(dat);
					$("#associationModal").modal('show');
				});
				
			});
	});
</script>
@endsection