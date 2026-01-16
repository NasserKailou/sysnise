@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Modification cadre projet</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.updateCadreProjet',['projet' => $projet->id]) }}" method="POST">
			@csrf
			<div class="row">
				<div class="row mb-3">
					<div class="col-md-6">
					  <label class="form-label">Intitulé</label>
					  <input name="intitule" type="text" class="form-control" value="{{ old('intitule', $projet->cadreDeveloppement->intitule) }}">
					</div>
					<div class="col-md-6">
					  <label class="form-label">Structure Responsable</label>
					  <input name="structure_responsable" type="text" class="form-control" value="{{ old('structure_responsable', $projet->cadreDeveloppement->structure_responsable) }}">
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-md-6">
					  <label class="form-label">Année de début</label>
					  <input name="annee_debut" type="text" class="form-control" value="{{ old('annee_debut', $projet->cadreDeveloppement->annee_debut) }}">
					</div>
					<div class="col-md-6">
					  <label class="form-label">Année de fin</label>
					  <input name="annee_fin" type="text" class="form-control" value="{{ old('annee_fin', $projet->cadreDeveloppement->annee_fin) }}">
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-md-12">
					  <label class="form-label">Description</label>
					  <textarea name="description"  class="form-control" rows="3">{{ $projet->cadreDeveloppement->description }}</textarea>
					</div>
				</div>
			  </div>
			  <!-- Boutons -->
			  <div class="mt-3 text-end">
				<a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
			  </div>
			</form>
		  </div>
        </div>
      </div>
    </div>
  </div>



@push('scripts')
<script>
$(document).ready(function() {
    
});
</script>
@endpush
@endsection