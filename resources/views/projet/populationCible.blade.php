@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
	  <div class="col-md-12 col-lg-12">
        <div class="card">
		  <div class="card-header">
			<strong>Population cible du projet : </strong>
		  </div>
		  <div class="card-body">
			<form action="{{ route('projets.populationCibles.store',['projet' => $projet->id]) }}" method="POST">
				@csrf
				<div class="row">
					<div class="row mb-3">
						<div class="col-md-6">
						  <label class="form-label">Population cible 
							<span style="color: red;">*</span>
						  </label>
						   <select name="population_cible_id" id="populationCibleSelect" class="form-select @error('PopulationCible') is-invalid @enderror" required>
								<option value="">-- Sélectionner la population cible --</option>
								@foreach($populationCibles as $population)
									<option value="{{ $population->id }}">
										{{ $population->intitule }}
									</option>
								@endforeach
								<option value="0">Autre à préciser</option>
							</select>
						</div>
						<div class="col-md-6">
						  <label class="form-label">Effectif 
							<span style="color: red;">*</span>
						  </label>
						  <input name="effectif" type="text" class="form-control" required>
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
                    <strong>Populations Cibles</strong>
                </div>
                <div class="card-body">
                    <table class="dataTable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Poulation Cible</th>
								<th class="text-left">Effectif</th>
                                <th class="text-center table-icons">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projet->PopulationCibles as $cible)
                            <tr>
                                <td class="text-left">{{ $cible->intitule }}</td>
								<td class="text-left">{{ $cible->pivot->effectif }}</td>
                                <td class="text-center table-icons">
                                    <a href="{{ route('projets.populationCibles.edit', [$projet->id,$cible->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('projets.populationCibles.destroy',[$projet->id,$cible->id]) }}" method="POST" style="display:inline-block;">
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

<div class="modal fade" id="addPopulationModal" tabindex="-1" aria-labelledby="addPopulationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPopulationModalLabel">Nouvelle population cible</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-content-body p-3">
                <form id="ajaxPopulationForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Intitulé</label>
                        <input name="intitule" id="newPopulationIntitule" type="text" class="form-control" required>
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
    // Détecter la sélection de "Autre à préciser"
    $('#populationCibleSelect').on('change', function() {
        if ($(this).val() === '0') {
            // Afficher le modal Bootstrap
            var myModal = new bootstrap.Modal(document.getElementById('addPopulationModal'));
            myModal.show();
        }
    });

    // Envoi du formulaire via AJAX
    $('#ajaxPopulationForm').on('submit', function(e) {
        e.preventDefault();

        let intitule = $('#newPopulationIntitule').val();
        let token = $("input[name='_token']").val();

        $.ajax({
            url: "{{ route('population_cibles.store') }}",
            type: "POST",
            data: {
                _token: token,
                intitule: intitule
            },
            success: function(response) {
                if(response.success) {
                    // 1. Ajouter l'élément au select juste avant l'option "Autre à préciser"
                    $('#populationCibleSelect option[value="0"]').before(
                        `<option value="${response.data.id}" selected>${response.data.intitule}</option>`
                    );
                    
                    // 2. Nettoyer et fermer le modal
                    $('#ajaxPopulationForm')[0].reset();
                    var modalElement = document.getElementById('addPopulationModal');
                    var modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
                } else {
                    alert("Une erreur est survenue lors de l'enregistrement.");
                }
            },
            error: function(xhr) {
                alert("Erreur serveur : Impossible d'ajouter la population cible.");
            }
        });
    });

    // Réinitialiser la sélection si le modal est fermé sans enregistrement
    $('#addPopulationModal').on('hidden.bs.modal', function () {
        if($('#populationCibleSelect').val() === '0'){
            $('#populationCibleSelect').val('');
        }
    });
});
</script>
@endsection