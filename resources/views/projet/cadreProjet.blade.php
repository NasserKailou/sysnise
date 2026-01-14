@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Initialisation cadre projet</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.storeCadreProjet',['projet' => $projet->id]) }}" method="POST">
			@csrf
			<div class="row">
				<div class="row mb-3">
					<div class="col-md-6">
					  <label class="form-label">Intitulé</label>
					  <input name="intitule" type="text" class="form-control" readonly value="{{ old('intitule', $projet->intitule) }}">
					</div>
					<div class="col-md-6">
					  <label class="form-label">Structure Responsable</label>
					  <input name="structure_responsable" type="text" class="form-control" readonly value="{{ old('direction_agence', $projet->direction_agence) }}">
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-md-6">
					  <label class="form-label">Année de début</label>
					  <input name="annee_debut" type="text" class="form-control" value="{{ old('annee_debut', \Carbon\Carbon::parse($projet->date_debut_prevue)->format('Y')) }}">
					</div>
					<div class="col-md-6">
					  <label class="form-label">Année de fin</label>
					  <input name="annee_fin" type="text" class="form-control" value="{{ old('annee_fin', \Carbon\Carbon::parse($projet->date_fin_prevue)->format('Y')) }}">
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-md-12">
					  <label class="form-label">Description</label>
					  <textarea name="description"  class="form-control" rows="3"></textarea>
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