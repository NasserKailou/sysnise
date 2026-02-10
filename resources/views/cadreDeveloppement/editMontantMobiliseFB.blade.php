@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Mise à jour montant mobilisé</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('cadre_developpements.financementParBailleur.montantMobilise.update',[$cadreDeveloppement->id,$montantMobilise->id ]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						
						<div class="col-md-4">
						  <label class="form-label">Année 
							<span style="color: red;">*</span>
						  </label>
						  <input name="annee" type="text" class="form-control" value="{{ old('annee', $montantMobilise->annee) }}" required>
						</div>
						<div class="col-md-4">
						  <label class="form-label">Montant 
							<span style="color: red;">*</span>
						  </label>
						  <input name="montant" type="text" class="form-control" value="{{ old('montant', $montantMobilise->montant) }}" required>
						</div>
					</div>
				</div>
				<div class="mt-3 text-end">
					<a href="{{ route('cadre_developpements.financementParBailleur', [$cadreDeveloppement->id])  }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
				</div>
			</form>
		  </div>
		</div>
	  </div>
	  
    </div>
</div>

@endsection