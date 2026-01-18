@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">

	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="form-section">
		  <div class="section-title d-flex justify-content-between"><span>Liste des cadres de devéloppement</span><button class="mr-3 btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter un cadre"><a href="{{ url('/cadre_developpements/create/') }}" style="color:#fff;text-decoration:none"><i class="fa fa-plus"></i> Nouveau</a></button></div>

          <div class="table-responsive">
			<table class="dataTable table table-striped table-bordered align-middle">
			  <thead class="table-light">
				<tr>
				  <th>Intitulé</th>
				  <th>Responsable</th>
				  <th>Période</th>
				  <th class="text-center table-icons">Action</th>
				</tr>
			  </thead>
			  <tbody>
				@foreach ($cadreDeveloppements as $cadre)
				<tr>
				  <td>{{ $cadre->intitule }}</td>
				  <td>{{ $cadre->structure_responsable }}</td>
				  <td>{{ $cadre->annee_debut }}- {{ $cadre->annee_fin }}</td>
				  <td class="text-center table-icons">
					<a href="{{ route('cadre_developpements.show', $cadre->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Voir les détails">
						<i class="fa fa-eye"></i>
					</a>
					<a href="{{ route('cadre_developpements.cadres_logiques.index', $cadre->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Afficher les cadres logiques">
						<i class="fa fa-list"></i>
					</a>
					<a href="{{ route('cadre_developpements.edit', $cadre->id) }}" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier">
						<i class="fa fa-pen"></i>
					</a>
                    <a href="{{ route('export_cadre_data_template', $cadre->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Telecharger modele de chargement">
						<i class="fa fa-download"></i>
					</a>
					<form action="{{ route('cadre_developpements.destroy', $cadre->id) }}" method="POST" class="d-inline">
						@csrf
						@method('DELETE')
						<button class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer" onclick="return confirm('Supprimer cet article ?')"><i class="fa fa-trash"></i></button>
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



@push('scripts')
<script>
$(document).ready(function() {

});
</script>
@endpush
@endsection
