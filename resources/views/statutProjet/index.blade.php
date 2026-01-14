@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Nouveau statut projet</strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('statut_projets.store') }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-12">
						  <label class="form-label">Intitulé</label>
						  <input name="intitule" type="text" class="form-control">
						</div>
					</div>
				</div>
				<div class="mt-3 text-end">
					<a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
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
                    <strong>Statuts Projet</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Intitulé</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statutProjets as $statutProjet)
                            <tr>
                                <td class="text-left">{{ $statutProjet->intitule }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('statut_projets.edit', $statutProjet->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('statut_projets.destroy',$statutProjet->id) }}" method="POST" style="display:inline-block;">
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