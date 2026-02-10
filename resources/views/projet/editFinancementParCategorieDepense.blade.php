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
			<form action="{{ route('projets.financementParCategorieDepense.update',[$projet->id,$planFinancement->id]) }}" method="POST">
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
									<option value="{{ $categorie->id }}"
										{{ old('categorie_depense_id', $categorieDepenseId ?? '') == $categorie->id ? 'selected' : '' }}>
										{{ $categorie->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Montant (FCFA) 
							<span style="color: red;">*</span>
						  </label>
						  <input name="montant" type="number" class="form-control" value="{{ old('montant', $montant) }}" required>
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
	
	<script>
	$(document).ready(function() {
		$.fn.zTree.init($("#liste_composante"), settingComposante, zNodesComposante);
		
	});
	</script>
</div>

@endsection