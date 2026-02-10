@extends('layouts.app')
@section('content')
<div class="container-fluid">
	
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Financement par bailleur du cadre de développement : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('cadre_developpements.financementParBailleur.store',['cadre_developpement' => $cadreDeveloppement->id]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
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
						
						<div class="col-md-12">
						  <label class="form-label">Montant (FCFA) 
							<span style="color: red;">*</span>
						  </label>
						  <input name="montant" type="number" class="form-control" required>
						</div>
						
					</div>
				</div>
				<div class="mt-3 text-end">
					<a href="{{ route('cadre_developpements.show', $cadreDeveloppement->id) }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
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
                    <strong>Financements du cadre de développement</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Bailleur</th>
								<th class="text-left">Coût</th>
								<th class="text-left">Montant mobilisé</th>
								<th class="text-left">Montant consommé</th>
								<th class="text-left">Montant à rechercher</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($financementParBailleurs as $financement)
                            <tr>
                                <td class="text-left">{{ $financement->bailleur->intitule ?? '-'  }}</td>
								<td class="text-left">{{ $financement->montant ?? '-' }}</td>
                                <td class="text-left">{{ $financement?->montantMobilises()->whereNull('deleted_on')->sum('montant') ?? 0  }}</td>
                                <td class="text-left">{{ $financement?->montantConsommes()->whereNull('deleted_on')->sum('montant') ?? 0  }}</td>
                                <td class="text-left">{{ $financement?->montantRecherches()->whereNull('deleted_on')->sum('montant') ?? 0  }}</td>
								
								<td class="text-center table-icons">
                                    <a href="{{ route('cadre_developpements.financementParBailleur.edit', [$cadreDeveloppement->id,$financement?->id]) }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier"><i class="fa fa-edit"></i></a>
									<a href="{{ route('cadre_developpements.financementParBailleur.montantMobilise', [$cadreDeveloppement->id,$financement?->id]) }}" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant mobilisé"><i class="fa fa-money-bill-wave"></i></a>
									<a href="{{ route('cadre_developpements.financementParBailleur.montantConsomme', [$cadreDeveloppement->id,$financement?->id]) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant consommé"><i class="fa fa-arrow-trend-down"></i></a>
									<a href="{{ route('cadre_developpements.financementParBailleur.montantRecherche', [$cadreDeveloppement->id,$financement?->id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Montant à rechercher"><i class="fa fa-hand-holding-dollar"></i></a>
									<form action="{{ route('cadre_developpements.financementParBailleur.destroy',[$cadreDeveloppement->id,$financement?->id]) }}" method="POST" style="display:inline-block;">
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
	
	<script>
	$(document).ready(function() {
		$.fn.zTree.init($("#liste_composante"), settingComposante, zNodesComposante);
		
	});
	</script>
</div>

@endsection