@extends('layouts.app')
@section('content')
<div class="container-fluid">
    @if(session('failed_unites'))
	<script>
		$(function () {
			@foreach(session('failed_unites') as $unite)
				$(document).Toasts('create', {
					class: 'bg-danger',
					title: 'Import échoué',
					body: `
						<strong>Intitulé :</strong> {{ $unite['intitule'] }}<br>
						<strong>Raison :</strong> {{ $unite['raison'] }}
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
			<strong>Nouvelle unité</strong>
			<a id="uploadUnites" href="#" class="ms-auto text-muted" title="Importer">
				<i class="fas fa-file-upload"></i>
			</a>
		  </div>
		  <div class="card-body">
			<form action="{{ route('unite_indicateurs.store') }}" method="POST">
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
                    <strong>Unités indicateurs</strong>
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
                            @foreach($uniteIndicateurs as $unite)
                            <tr>
                                <td class="text-left">{{ $unite->intitule }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('unite_indicateurs.edit', $unite->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('unite_indicateurs.destroy',$unite->id) }}" method="POST" style="display:inline-block;">
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
		$(document).ready(function () {
			$('#uploadUnites').click(function(){
				$.get('/unite_indicateurs/upload',function(dat){
					$('#popup').html(dat);
					$("#myModal").modal('show');
				});
				
			});
		});
	</script>
</div>

@endsection