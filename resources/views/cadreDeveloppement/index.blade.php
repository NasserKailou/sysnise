@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="form-section">
                <div class="section-title d-flex justify-content-between">
                    <span>Liste des cadres de développement</span>
                    <a href="{{ url('/cadre_developpements/create/') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Nouveau
                    </a>
                </div>

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
                                <td>{{ $cadre->annee_debut }} - {{ $cadre->annee_fin }}</td>
                                <td class="text-center table-icons">

                                    <a href="{{ route('cadre_developpements.show', $cadre->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="{{ route('cadre_developpements.cadres_logiques.index', $cadre->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-list"></i>
                                    </a>

                                    <a href="{{ route('cadre_developpements.edit', $cadre->id) }}" class="btn btn-success btn-sm">
                                        <i class="fa fa-pen"></i>
                                    </a>

                                    <a href="{{ route('export_cadre_data_template', $cadre->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-download"></i>
                                    </a>

                                    <!-- Modal dynamique -->
                                    <button class="btn btn-dark btn-sm open-modal viewAssociationsModal"
                                        data-id="{{ $cadre->id }}"
                                        data-intitule="{{ $cadre->intitule }}"
                                        data-bs-toggle="modal">
                                        <i class="fa fa-list-alt"></i>
                                    </button>

                                    <!-- Association -->
                                    <button class="btn btn-secondary btn-sm open-association-modal associationModal"
                                        data-id="{{ $cadre->id }}"
                                        data-intitule="{{ $cadre->intitule }}"
                                        data-bs-toggle="modal">
                                        <i class="fa fa-link"></i>
                                    </button>

                                    <form action="{{ route('cadre_developpements.destroy', $cadre->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet élément ?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
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
<div id="popup"></div>
<script>
	$(document).ready(function () {
		
		$('.viewAssociationsModal').click(function(){
				cadreId = $(this).data('id');
				$.get('/cadre_developpements/'+cadreId+'/viewAssociations',function(dat){
					$('#popup').html(dat);
					$("#viewAssociationsModal").modal('show');
				});
				
			});
			
		$('.associationModal').click(function(){
				cadreId = $(this).data('id');
				$.get('/cadre_developpements/'+cadreId+'/association',function(dat){
					$('#popup').html(dat);
					$("#associationModal").modal('show');
				});
				
			});
	});
</script>

@endsection