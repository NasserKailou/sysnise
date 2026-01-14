@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Mise à jour Etude Envisagée : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.etudeEnvisagees.update',['projet' => $projet->id, 'etude'  => $etudeId, 'sourceFinancement'  => $sourceFinancementId]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-6">
						  <label class="form-label">Etude</label>
						   <select name="etude_id" class="form-select @error('Etude') is-invalid @enderror">
								<option value="">-- Sélectionner une étude --</option>
								@foreach($etudes as $etude)
									<option value="{{ $etude->id }}"
										{{ old('etude_id', $etudeId ?? '') == $etude->id ? 'selected' : '' }}>
										{{ $etude->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Source de Financement</label>
						   <select name="source_financement_id" class="form-select @error('Etude') is-invalid @enderror">
								<option value="">-- Sélectionner une source de financement --</option>
								@foreach($sourceFinancements as $source)
									<option value="{{ $source->id }}"
										{{ old('source_financement_id', $sourceFinancementId ?? '') == $source->id ? 'selected' : '' }}>
										{{ $source->intitule }}
									</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="mt-3 text-end">
					<a href="{{ route('projets.show', $projet->id) }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
				</div>
			</form>
		  </div>
		</div>
	  </div>
	  
    </div>
</div>

@endsection