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
			<form action="{{ route('projets.planFinancements.store',['projet' => $projet->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-6">
						  <label class="form-label">Source de Financement</label>
						   <select name="source_financement_id" class="form-select @error('Etude') is-invalid @enderror">
								<option value="">-- Sélectionner une source de financement --</option>
								@foreach($sourceFinancements as $source)
									<option value="{{ $source->id }}">
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
									<option value="{{ $bailleur->id }}">
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
									<option value="{{ $statut->id }}">
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
									<option value="{{ $nature->id }}">
										{{ $nature->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Composante</label>
						   <select name="composante_id" class="form-select @error('composante') is-invalid @enderror">
								<option value="">-- Sélectionner une composante --</option>
								@foreach($composantes as $composante)
									<option value="{{ $composante->id }}">
										{{ $composante->intitule }}
									</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Montant (FCFA)</label>
						  <input name="montant" type="number" class="form-control">
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
                                <th class="text-left">Composante</th>
								<th class="text-left">Bailleur</th>
								<th class="text-left">Nature</th>
								<th class="text-left">Montant</th>
								<th class="text-left">Tot Prévu</th>
								<th class="text-left">Tot Dépensé</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projet->planFinancements as $financement)
                            <tr>
                                <td class="text-left">{{ $financement->pivot->composante->intitule ?? '-'  }}</td>
								<td class="text-left">{{ $financement->pivot->bailleur->intitule ?? '-' }}</td>
								<td class="text-left">{{ $financement->pivot->natureFinancement->intitule ?? '-' }}</td>
								<td class="text-left">{{ $financement->pivot->montant ?? '-' }}</td>
                                @php
									$planFinancement = \App\Models\PlanFinancement::find($financement->id);
								@endphp
								<td class="text-left">{{ $planFinancement?->budgetsAnnuelsPrevus()->sum('montant') ?? 0  }}</td>
                                <td class="text-left">{{ $planFinancement?->budgetsAnnuelsDepenses()->sum('montant') ?? 0  }}</td>
                                
								<td class="text-center table-icons">
                                    <a href="{{ route('projets.planFinancements.budgetAnnuelPrevu', [$projet->id,$financement->id]) }}" class="btn btn-sm btn-primary">Montants prévus</a>
									<a href="{{ route('projets.planFinancements.budgetAnnuelDepense', [$projet->id,$financement->id]) }}" class="btn btn-sm btn-success">Montants dépensés</a>
									<a href="{{ route('projets.planFinancements.edit', [$projet->id,$financement->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
									<form action="{{ route('projets.planFinancements.destroy',[$projet->id,$financement->id]) }}" method="POST" style="display:inline-block;">
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