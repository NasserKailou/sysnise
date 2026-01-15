@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Modification population cible du projet : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.populationCibles.update',['projet' => $projet->id, 'populationCible' => $populationCibleId]) }}" method="POST">
				@csrf
				@method('PUT')
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-6">
						  <label class="form-label">Population cible 
							<span style="color: red;">*</span>
						  </label>
						   <select name="population_cible_id" class="form-select @error('PopulationCible') is-invalid @enderror" required>
								<option value="">-- Sélectionner la population cible --</option>
								@foreach($populationCibles as $population)
									<option value="{{ $population->id }}"
										{{ old('population_cible_id', $populationCibleId ?? '') == $population->id ? 'selected' : '' }}>
										{{ $population->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Effectif 
							<span style="color: red;">*</span>
						  </label>
						  <input name="effectif" type="text" class="form-control" value="{{ old('effectif', $effectif) }}" required>
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