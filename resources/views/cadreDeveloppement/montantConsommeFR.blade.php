@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Montant consommé</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('cadre_developpements.financementParResultat.montantConsomme.store',['cadre_developpement' => $cadreDeveloppement->id,'financementParResultat' => $financementParResultat->id ]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						
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
					<a href="{{ route('cadre_developpements.financementParResultat', ['cadre_developpement' => $cadreDeveloppement->id])  }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
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
                    <strong>Montants mobilisés par an</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Année</th>
								<th class="text-left">Montant</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($montantConsommes as $montantConsomme)
                            <tr>
                                <td class="text-left">{{ $montantConsomme->annee }}</td>
								<td class="text-left">{{ $montantConsomme->montant }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('cadre_developpements.financementParResultat.montantConsomme.edit', [$cadreDeveloppement->id, $montantConsomme->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('cadre_developpements.financementParResultat.montantConsomme.destroy', [$cadreDeveloppement->id, $montantConsomme->id]) }}" method="POST" style="display:inline-block;">
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