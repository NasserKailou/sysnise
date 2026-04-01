<html>
<head>
	<meta charset="utf-8" />
</head>
<body>
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
</body>
</html>