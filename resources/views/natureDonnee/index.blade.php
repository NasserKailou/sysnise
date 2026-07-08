@extends('layouts.app')
@section('content')
<div class="container-fluid">
    @if(session('failed_nature_donnees'))
	<script>
		$(function () {
			@foreach(session('failed_nature_donnees') as $nature_donnee)
				$(document).Toasts('create', {
					class: 'bg-danger',
					title: 'Import échoué',
					body: `
						<strong>Intitulé :</strong> {{ $nature_donnee['intitule'] }}<br>
						<strong>Raison :</strong> {{ $nature_donnee['raison'] }}
					`,
					autohide: false
				});
			@endforeach
		});
	</script>
	@endif
	<div class="row">
	  <!-- Contenu principal -->
      <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header d-flex  align-items-center">
			<strong>Nouvelle nature donnée</strong>
			<a id="uploadNatureDonnees" href="#" class="ms-auto text-muted" title="Importer">
				<i class="fas fa-file-upload"></i>
			</a>
		  </div>
		  <div class="card-body">
			<form action="{{ route('nature_donnees.store') }}" method="POST">
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
                    <strong>Natures Données</strong>
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
                            @foreach($natureDonnees as $natureDonnee)
                            <tr>
                                <td class="text-left">{{ $natureDonnee->intitule }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('nature_donnees.edit', $natureDonnee->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('nature_donnees.destroy',$natureDonnee->id) }}" method="POST" style="display:inline-block;">
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
		  <script>
			$(document).ready(function () {
				$('#uploadNatureDonnees').click(function(){
					$.get('/nature_donnees/upload',function(dat){
						$('#popup').html(dat);
						$("#myModal").modal('show');
					});
					
				});
			});
		</script>
    </div>
</div>

@endsection