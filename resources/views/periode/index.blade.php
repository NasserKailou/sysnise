@extends('layouts.app')
@section('content')
<div class="container-fluid">
	@if(session('failed_periodes'))
	<script>
		$(function () {
			@foreach(session('failed_periodes') as $periode)
				$(document).Toasts('create', {
					class: 'bg-danger',
					title: 'Import échoué',
					body: `
						<strong>Intitulé :</strong> {{ $periode['intitule'] }}<br>
						<strong>Raison :</strong> {{ $periode['raison'] }}
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
			<strong>Nouvelle période</strong>
			<a id="uploadPeriodes" href="#" class="ms-auto text-muted" title="Importer">
				<i class="fas fa-file-upload"></i>
			</a>
		  </div>
		  <div class="card-body">
			<form action="{{ route('periodes.store') }}" method="POST">
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
                    <strong>Périodes</strong>
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
                            @foreach($periodes as $periode)
                            <tr>
                                <td class="text-left">{{ $periode->intitule }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('periodes.edit', $periode->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('periodes.destroy',$periode->id) }}" method="POST" style="display:inline-block;">
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
			$('#uploadPeriodes').click(function(){
				$.get('/periodes/upload',function(dat){
					$('#popup').html(dat);
					$("#myModal").modal('show');
				});
				
			});
		});
	</script>
	  
    </div>
</div>

@endsection