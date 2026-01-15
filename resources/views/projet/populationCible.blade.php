@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Population cible du projet : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.populationCibles.store',['projet' => $projet->id]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-6">
						  <label class="form-label">Population cible 
							<span style="color: red;">*</span>
						  </label>
						   <select name="population_cible_id" class="form-select @error('PopulationCible') is-invalid @enderror" required>
								<option value="">-- Sélectionner la population cible --</option>
								@foreach($populationCibles as $population)
									<option value="{{ $population->id }}">
										{{ $population->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Effectif 
							<span style="color: red;">*</span>
						  </label>
						  <input name="effectif" type="text" class="form-control" required>
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
	  
	  <!-- Tableau des pièces jointes -->
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Populations Cibles</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Poulation Cible</th>
								<th class="text-left">Effectif</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projet->PopulationCibles as $cible)
                            <tr>
                                <td class="text-left">{{ $cible->intitule }}</td>
								<td class="text-left">{{ $cible->pivot->effectif }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('projets.populationCibles.edit', [$projet->id,$cible->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('projets.populationCibles.destroy',[$projet->id,$cible->id]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')"><i class="fa fa-trash"></i></button>
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