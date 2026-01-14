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
			<form action="{{ route('projets.rechercheFinancements.update',['projet' => $projet->id,'sourceFinancement'=> $sourceFinancementId,'bailleur'=> $bailleurId,'statutFinancement'=> $statutFinancementId ,'natureFinancement'=> $natureFinancementId,]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
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
						<div class="col-md-6">
						  <label class="form-label">Bailleur</label>
						   <select name="bailleur_id" class="form-select @error('PFT') is-invalid @enderror">
								<option value="">-- Sélectionner un Bailleur --</option>
								@foreach($bailleurs as $bailleur)
									<option value="{{ $bailleur->id }}"
										{{ old('bailleur_id', $bailleurId ?? '') == $bailleur->id ? 'selected' : '' }}>
										{{ $bailleur->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Statut Financement</label>
						   <select name="statut_financement_id" class="form-select @error('statutFinancement') is-invalid @enderror">
								<option value="">-- Sélectionner un statut --</option>
								@foreach($statutFinancements as $statut)
									<option value="{{ $statut->id }}"
										{{ old('statut_financement_id', $statutFinancementId ?? '') == $statut->id ? 'selected' : '' }}>
										{{ $statut->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Nature Financement</label>
						   <select name="nature_financement_id" class="form-select @error('natureFinancement') is-invalid @enderror">
								<option value="">-- Sélectionner une nature --</option>
								@foreach($natureFinancements as $nature)
									<option value="{{ $nature->id }}"
										{{ old('nature_financement_id', $natureFinancementId ?? '') == $nature->id ? 'selected' : '' }}>
										{{ $nature->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-12">
						  <label class="form-label">Montant (FCFA)</label>
						  <input name="montant" type="number" class="form-control" value="{{ old('montant', $montant) }}">
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