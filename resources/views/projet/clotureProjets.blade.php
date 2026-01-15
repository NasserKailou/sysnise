@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Clôture de projet</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.clotureProjets.store',[$projet->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row mb-3">
					<div class="col-md-3">
					  <label class="form-label">Coût effectif</label>
					  <input name="cout_effectif" type="text" class="form-control">
					</div>
					
					<div class="col-md-3">
					  <label class="form-label">Date début effectif</label>
					  <input name="date_debut_effectif" type="date" class="form-control">
					</div>
					
					<div class="col-md-3">
					  <label class="form-label">Date fin effectif</label>
					  <input name="date_fin_effectif" type="date" class="form-control">
					</div>
					
					<div class="col-md-3">
					  <label class="form-label">Durée</label>
					  <input name="duree_effectif" type="text" class="form-control">
					</div>
					
				</div>
				<div class="row mb-3">
					<div class="col-md-6">
					  <label class="form-label">Rapport d'achèvement</label>
					  <input name="rapport_achevement" type="file" class="form-control" required>
					</div>
					<div class="col-md-6">
					  <label class="form-label">Date du Rapport d'achèvement</label>
					  <input name="date_rapport_achevement" type="date" class="form-control">
					</div>
					<div class="col-md-12 mt-3">
					  <label class="form-label">Conclusion du Rapport d'achèvement</label>
					  <textarea name="conclusion_rapport_achevement"  class="form-control" rows="3"></textarea>
					</div>
					
				</div>
				<div class="row mb-3">
					<div class="col-md-6">
					  <label class="form-label">Rapport de clôture</label>
					  <input name="rapport_cloture" type="file" class="form-control" required>
					</div>
					<div class="col-md-6">
					  <label class="form-label">Date du Rapport de clôture</label>
					  <input name="date_rapport_cloture" type="date" class="form-control">
					</div>
					<div class="col-md-12 mt-3">
					  <label class="form-label">Conclusion du Rapport de clôture</label>
					  <textarea name="conclusion_rapport_cloture"  class="form-control" rows="3"></textarea>
					</div>
					
				</div>
				<div class="row mb-3">
					<div class="col-md-12">
					  <label class="form-label">Date de fermeture des comptes</label>
					  <input name="date_fermeture_comptes" type="date" class="form-control">
					</div>
					<div class="col-md-12">
					  <label class="form-label">Référence du document de fermeture des comptes </label>
					  <input name="reference_document_fermeture_comptes" type="text" class="form-control" required>
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
                    <strong>Clôture de projet</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Date début effectif</th>
								<th class="text-left">Date fin effectif</th>
								<th class="text-left">Coût effectif</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clotureProjet as $cloture)
                            <tr>
                                <td class="text-left">{{ $cloture->date_debut_effectif }}</td>
								<td class="text-left">{{ $cloture->date_fin_effectif }}</td>
								<td class="text-left">{{ $cloture->cout_effectif }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('projets.clotureProjets.edit', [$projet->id, $cloture->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('projets.clotureProjets.destroy',[$projet->id, $cloture->id]) }}" method="POST" style="display:inline-block;">
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