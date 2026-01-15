@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Plan de Financement</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.planFinancements.budgetAnnuel.store',['projet' => $projet->id,'planFinancement' => $planFinancement->id ]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-4">
						  <label class="form-label">Catégorie de dépense 
							<span style="color: red;">*</span>
						  </label>
						   <select name="categorie_depense_id" class="form-select @error('categorieDepense') is-invalid @enderror" required>
								<option value="">-- Sélectionner une catégorie --</option>
								@foreach($categorieDepenses as $categorie)
									<option value="{{ $categorie->id }}">
										{{ $categorie->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-4">
						  <label class="form-label">Année 
							<span style="color: red;">*</span>
						  </label>
						  <input name="annee" type="text" class="form-control" required>
						</div>
						<div class="col-md-4">
						  <label class="form-label">Montant 
							<span style="color: red;">*</span>
						  </label>
						  <input name="montant" type="text" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="mt-3 text-end">
					<a href="{{ route('projets.planFinancements', ['projet' => $projet->id])  }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
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
                    <strong>Prévision des montants</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Catégorie dépense</th>
								<th class="text-left">Année</th>
								<th class="text-left">Montant</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($budgets as $budget)
                            <tr>
                                <td class="text-left">{{ $budget->categorieDepense->intitule }}</td>
								<td class="text-left">{{ $budget->annee }}</td>
								<td class="text-left">{{ $budget->montant }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('projets.planFinancements.budgetAnnuel.edit', [$projet->id, $budget->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('projets.planFinancements.budgetAnnuel.destroy', [$projet->id, $budget->id]) }}" method="POST" style="display:inline-block;">
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