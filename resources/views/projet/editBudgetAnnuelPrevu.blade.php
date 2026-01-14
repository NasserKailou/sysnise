@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Mise à jour Plan de Financement</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.planFinancements.budgetAnnuelPrevu.update',['projet' => $projet->id,'budgetAnnuelPrevu' => $budgetAnnuelPrevu->id ]) }}" method="POST">
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
									<option value="{{ $categorie->id }}"
										{{ old('categorie_depense_id', $budgetAnnuelPrevu->categorieDepense->id ?? '') == $categorie->id ? 'selected' : '' }}>
										{{ $categorie->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-4">
						  <label class="form-label">Année 
							<span style="color: red;">*</span>
						  </label>
						  <input name="annee" type="text" class="form-control" value="{{ old('annee', $budgetAnnuelPrevu->annee) }}" required>
						</div>
						<div class="col-md-4">
						  <label class="form-label">Montant 
							<span style="color: red;">*</span>
						  </label>
						  <input name="montant" type="text" class="form-control" value="{{ old('montant', $budgetAnnuelPrevu->montant) }}" required>
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
	  
    </div>
</div>

@endsection