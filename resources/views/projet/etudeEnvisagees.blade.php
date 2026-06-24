@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Etude Envisagée : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.etudeEnvisagees.store',['projet' => $projet->id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-6">
						  <label class="form-label">Etude 
							<span style="color: red;">*</span>
						  </label>
						   <select name="etude_id" id="etudeSelect" class="form-select @error('Etude') is-invalid @enderror" required>
								<option value="">-- Sélectionner une étude --</option>
								@foreach($etudes as $etude)
									<option value="{{ $etude->id }}">
										{{ $etude->intitule }}
									</option>
								@endforeach
								<option value="0">Autre à préciser</option>
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Source de Financement 
							<span style="color: red;">*</span>
						  </label>
						   <select name="source_financement_id" id="sourceFinancementSelect" class="form-select @error('Etude') is-invalid @enderror" required>
								<option value="">-- Sélectionner une source de financement --</option>
								@foreach($sourceFinancements as $source)
									<option value="{{ $source->id }}">
										{{ $source->intitule }}
									</option>
								@endforeach
								<option value="0">Autre à préciser</option>
							</select>
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
	  
	  <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong>Etudes Envisagées</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Etude</th>
								<th class="text-left">Source de financement</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projet->etudeEnvisagees as $ED)
                            <tr>
                                <td class="text-left">{{ $ED->intitule }}</td>
								<td class="text-left">{{ $ED->pivot->sourceFinancement->intitule ?? '-' }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('projets.etudeEnvisagees.edit', [$projet->id,$ED->id,$ED->pivot->sourceFinancement->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('projets.etudeEnvisagees.destroy',[$projet->id,$ED->id,$ED->pivot->sourceFinancement->id]) }}" method="POST" style="display:inline-block;">
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

<div class="modal fade" id="addEtudeModal" tabindex="-1" aria-labelledby="addEtudeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEtudeModalLabel">Nouvelle étude</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-content-body p-3">
                <form id="ajaxEtudeForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Intitulé</label>
                        <input name="intitule" id="newEtudeIntitule" type="text" class="form-control" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addSourceFinancementModal" tabindex="-1" aria-labelledby="addSourceFinancementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSourceFinancementModalLabel">Nouvelle source de financement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-content-body p-3">
                <form id="ajaxSourceFinancementForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Intitulé de la source</label>
                        <input name="intitule" id="newSourceFinancementIntitule" type="text" class="form-control" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    
    // ==========================================
    // 1. GESTION DYNAMIQUE DU SELECT ÉTUDE
    // ==========================================
    $('#etudeSelect').on('change', function() {
        if ($(this).val() === '0') {
            var myModal = new bootstrap.Modal(document.getElementById('addEtudeModal'));
            myModal.show();
        }
    });

    $('#ajaxEtudeForm').on('submit', function(e) {
        e.preventDefault();
        let intitule = $('#newEtudeIntitule').val();
        let token = $("input[name='_token']").val();

        $.ajax({
            url: "{{ route('etudes.store') }}",
            type: "POST",
            data: { _token: token, intitule: intitule },
            success: function(response) {
                if(response.success) {
                    $('#etudeSelect option[value="0"]').before(
                        `<option value="${response.data.id}" selected>${response.data.intitule}</option>`
                    );
                    $('#ajaxEtudeForm')[0].reset();
                    var modalInstance = bootstrap.Modal.getInstance(document.getElementById('addEtudeModal'));
                    modalInstance.hide();
                } else {
                    alert("Une erreur est survenue.");
                }
            },
            error: function() { alert("Erreur serveur : Impossible d'ajouter l'étude."); }
        });
    });

    $('#addEtudeModal').on('hidden.bs.modal', function () {
        if($('#etudeSelect').val() === '0') { $('#etudeSelect').val(''); }
    });

    // ==========================================
    // 2. GESTION DYNAMIQUE DU SELECT SOURCE FINANCEMENT
    // ==========================================
    $('#sourceFinancementSelect').on('change', function() {
        if ($(this).val() === '0') {
            var myModal = new bootstrap.Modal(document.getElementById('addSourceFinancementModal'));
            myModal.show();
        }
    });

    $('#ajaxSourceFinancementForm').on('submit', function(e) {
        e.preventDefault();
        let intitule = $('#newSourceFinancementIntitule').val();
        let token = $("input[name='_token']").val();

        $.ajax({
            url: "{{ route('source_financements.store') }}", // Modifiez cette route si le nom exact est différent
            type: "POST",
            data: { _token: token, intitule: intitule },
            success: function(response) {
                if(response.success) {
                    // Ajouter l'élément juste avant l'option "Autre à préciser"
                    $('#sourceFinancementSelect option[value="0"]').before(
                        `<option value="${response.data.id}" selected>${response.data.intitule}</option>`
                    );
                    $('#ajaxSourceFinancementForm')[0].reset();
                    var modalInstance = bootstrap.Modal.getInstance(document.getElementById('addSourceFinancementModal'));
                    modalInstance.hide();
                } else {
                    alert("Une erreur est survenue.");
                }
            },
            error: function() { alert("Erreur serveur : Impossible d'ajouter la source de financement."); }
        });
    });

    $('#addSourceFinancementModal').on('hidden.bs.modal', function () {
        if($('#sourceFinancementSelect').val() === '0') { $('#sourceFinancementSelect').val(''); }
    });
});
</script>
@endsection