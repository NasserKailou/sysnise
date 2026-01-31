@extends('layouts.app')
@section('content')
<div class="container-fluid">
	
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Plan de Financement du projet : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.financementParCategorieDepense.store',['projet' => $projet->id]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
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
                                <th class="text-left">Catégorie de dépense</th>
								<th class="text-left">Coût</th>
								<th class="text-left">Mont. Budgétisé</th>
								<th class="text-left">Mont. PTBA</th>
								<th class="text-left">Mont. Dépensé</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($planFinancements as $financement)
                            <tr>
                                <td class="text-left">{{ $financement->categorieDepense->intitule ?? '-'  }}</td>
								<td class="text-left">{{ $financement->montant ?? '-' }}</td>
                                <td class="text-left">{{ $financement?->budgetsAnnuels()->sum('montant') ?? 0  }}</td>
                                <td class="text-left">{{ $financement?->budgetsAnnuelsPrevus()->sum('montant') ?? 0  }}</td>
                                <td class="text-left">{{ $financement?->budgetsAnnuelsDepenses()->sum('montant') ?? 0  }}</td>
								
								<td class="text-center table-icons">
                                    <a href="{{ route('projets.financementParCategorieDepense.edit', [$projet->id,$financement?->id]) }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier"><i class="fa fa-edit"></i></a>
									<a href="{{ route('projets.planFinancements.budgetAnnuel', [$projet->id,$financement?->id]) }}" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant budgétisé"><i class="fa fa-hand-holding-dollar"></i></a>
									<a href="{{ route('projets.planFinancements.budgetAnnuelPrevu', [$projet->id,$financement?->id]) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant prévu"><i class="fa fa-money-bill-wave"></i></a>
									<a href="{{ route('projets.planFinancements.budgetAnnuelDepense', [$projet->id,$financement?->id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant dépensé"><i class="fa fa-arrow-trend-down"></i></a>
									<form action="{{ route('projets.planFinancements.destroy',[$projet->id,$financement?->id]) }}" method="POST" style="display:inline-block;">
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