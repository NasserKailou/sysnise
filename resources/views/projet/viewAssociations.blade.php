<html>
<head>
	<meta charset="utf-8" />
</head>
<body>
	<div class="modal fade" id="viewAssociationsModal" tabindex="-1" aria-labelledby="viewAssociationsModalLabel{{ $projet->id }}" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="viewAssociationsModalLabel{{ $projet->id }}">Associations de "{{ $projet->intitule }}"</h5>
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
</body>
</html>