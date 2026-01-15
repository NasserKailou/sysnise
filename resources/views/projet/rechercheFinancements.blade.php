@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Recherche de Financement du projet : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.rechercheFinancements.store',['projet' => $projet->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-6">
						  <label class="form-label">Source de Financement 
							<span style="color: red;">*</span>
						  </label>
						   <select name="source_financement_id" class="form-select @error('Etude') is-invalid @enderror" required>
								<option value="">-- Sélectionner une source de financement --</option>
								@foreach($sourceFinancements as $source)
									<option value="{{ $source->id }}">
										{{ $source->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Bailleur 
							<span style="color: red;">*</span>
						  </label>
						   <select name="bailleur_id" class="form-select @error('PFT') is-invalid @enderror" required>
								<option value="">-- Sélectionner un Bailleur --</option>
								@foreach($bailleurs as $bailleur)
									<option value="{{ $bailleur->id }}">
										{{ $bailleur->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Statut Financement 
							<span style="color: red;">*</span>
						  </label>
						   <select name="statut_financement_id" class="form-select @error('statutFinancement') is-invalid @enderror" required>
								<option value="">-- Sélectionner un statut --</option>
								@foreach($statutFinancements as $statut)
									<option value="{{ $statut->id }}">
										{{ $statut->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Nature Financement 
							<span style="color: red;">*</span>
						  </label>
						   <select name="nature_financement_id" class="form-select @error('natureFinancement') is-invalid @enderror" required>
								<option value="">-- Sélectionner une nature --</option>
								@foreach($natureFinancements as $nature)
									<option value="{{ $nature->id }}">
										{{ $nature->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-12">
						  <label class="form-label">Montant (FCFA) 
							<span style="color: red;">*</span>
						  </label>
						  <input name="montant" type="number" class="form-control" required>
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
                    <strong>Financements du projet</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Source</th>
								<th class="text-left">Bailleur</th>
								<th class="text-left">Statut</th>
								<th class="text-left">Nature</th>
								<th class="text-left">Montant</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projet->rechercheFinancements as $financement)
                            <tr>
                                <td class="text-left">{{ $financement->intitule }}</td>
								<td class="text-left">{{ $financement->pivot->bailleur->intitule ?? '-' }}</td>
								<td class="text-left">{{ $financement->pivot->statutFinancement->intitule ?? '-' }}</td>
								<td class="text-left">{{ $financement->pivot->natureFinancement->intitule ?? '-' }}</td>
								<td class="text-left">{{ $financement->pivot->montant ?? '-' }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('projets.rechercheFinancements.edit', [$projet->id,$financement->pivot->bailleur->id,$financement->id,$financement->pivot->statutFinancement->id,$financement->pivot->natureFinancement->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('projets.rechercheFinancements.destroy',[$projet->id,$financement->pivot->bailleur->id,$financement->id,$financement->pivot->statutFinancement->id,$financement->pivot->natureFinancement->id]) }}" method="POST" style="display:inline-block;">
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